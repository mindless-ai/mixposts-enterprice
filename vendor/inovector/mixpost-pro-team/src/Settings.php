<?php

namespace Inovector\Mixpost;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Inovector\Mixpost\Models\Setting;

class Settings
{
    protected mixed $config;

    public function __construct(Container $container)
    {
        $this->config = $container->make('config');
    }

    public function form(): array
    {
        return [
            'locale' => Mixpost::getDefaultLocale(),
            'timezone' => 'UTC',
            'time_format' => 12,
            'week_starts_on' => 1,
            'default_accounts' => [],
        ];
    }

    public function rules(): array
    {
        return [
            'locale' => ['required', Rule::in(Arr::pluck(Util::config('locales'), 'long'))],
            'timezone' => ['required', 'timezone'],
            'time_format' => ['required', Rule::in([12, 24])],
            'week_starts_on' => ['required', Rule::in([0, 1])],
        ];
    }

    public function put(string $name, mixed $value = null, ?int $userId = null): void
    {
        Cache::put($this->resolveCacheKey($name, $userId), $value);
    }

    public function get(string $name, ?int $userId = null)
    {
        $userId = $userId ?: Auth::id();

        return $this->getFromCache($name, function () use ($name, $userId) {
            $record = Setting::where('user_id', $userId)->where('name', $name)->first();

            $defaultPayload = $record ? $record->payload : $this->form()[$name];

            $this->put($name, $defaultPayload);

            return $defaultPayload;
        }, $userId);
    }

    public function all(?int $userId = null): array
    {
        return Arr::map($this->form(), function ($payload, $name) use ($userId) {
            return $this->get($name, $userId);
        });
    }

    public function getFromCache(string $name, mixed $default = null, ?int $userId = null)
    {
        return Cache::get($this->resolveCacheKey($name, $userId), $default);
    }

    public function forget(string $name, ?int $userId = null): void
    {
        Cache::forget($this->resolveCacheKey($name, $userId));
    }

    public function forgetAll(?int $userId = null): void
    {
        foreach ($this->form() as $name => $payload) {
            $this->forget($name, $userId);
        }
    }

    private function resolveCacheKey(string $key, ?int $userId = null): string
    {
        $userId = $userId ?: Auth::id();

        return $this->config->get('mixpost.cache_prefix') . ".settings.$userId.$key";
    }
}
