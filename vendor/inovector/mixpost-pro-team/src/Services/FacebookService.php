<?php

namespace Inovector\Mixpost\Services;

use Illuminate\Validation\Rule;
use Inovector\Mixpost\Abstracts\Service;
use Inovector\Mixpost\Enums\ServiceGroup;

class FacebookService extends Service
{
    public static function group(): ServiceGroup
    {
        return ServiceGroup::SOCIAL;
    }

    public static function form(): array
    {
        return [
            'client_id' => '',
            'client_secret' => '',
            'api_version' => current(self::versions())
        ];
    }

    public static function formRules(): array
    {
        return [
            "client_id" => ['required'],
            "client_secret" => ['required'],
            "api_version" => ['required', Rule::in(self::versions())],
        ];
    }

    public static function formMessages(): array
    {
        return [
            'client_id' => __('validation.required', ['attribute' => 'App ID']),
            'client_secret' => __('validation.required', ['attribute' => 'APP Secret']),
            'api_version' => __('validation.required', ['attribute' => 'API Version']),
        ];
    }

    public static function versions(): array
    {
        return ['v22.0', 'v21.0', 'v20.0', 'v19.0', 'v18.0', 'v17.0', 'v16.0'];
    }
}
