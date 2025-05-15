<?php

namespace Inovector\Mixpost\SocialProviders\Google;

use Inovector\Mixpost\Abstracts\SocialProvider;
use Inovector\Mixpost\Contracts\AccountResource;
use Inovector\Mixpost\Contracts\SocialProviderPostOptions;
use Inovector\Mixpost\Services\GoogleService;
use Inovector\Mixpost\SocialProviders\Google\Concerns\ManagesOAuth;
use Inovector\Mixpost\SocialProviders\Google\Concerns\ManagesRateLimit;
use Inovector\Mixpost\SocialProviders\Google\Concerns\ManagesYoutubeResources;
use Inovector\Mixpost\SocialProviders\Google\Support\YoutubePostOptions;
use Inovector\Mixpost\Support\SocialProviderPostConfigs;
use Inovector\Mixpost\Util;

class YoutubeProvider extends SocialProvider
{
    public bool $onlyUserAccount = false;
    public array $callbackResponseKeys = ['code'];

    use ManagesRateLimit;
    use ManagesOAuth;
    use ManagesYoutubeResources;

    public static function name(): string
    {
        return 'YouTube';
    }

    public static function service(): string
    {
        return GoogleService::class;
    }

    public static function postConfigs(): SocialProviderPostConfigs
    {
        return SocialProviderPostConfigs::make()
            ->simultaneousPosting(Util::config('social_provider_options.youtube.simultaneous_posting_on_multiple_accounts'))
            ->minTextChar(0)
            ->maxTextChar(Util::config('social_provider_options.youtube.post_character_limit'))
            ->minVideos(1)
            ->maxPhotos(Util::config('social_provider_options.youtube.media_limit.photos'))
            ->maxVideos(Util::config('social_provider_options.youtube.media_limit.videos'))
            ->maxGifs(Util::config('social_provider_options.youtube.media_limit.gifs'))
            ->allowMixingMediaTypes(Util::config('social_provider_options.youtube.allow_mixing'));
    }

    public static function postOptions(): SocialProviderPostOptions
    {
        return new YoutubePostOptions;
    }

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://www.youtube.com/watch?v={$accountResource->pivot->provider_post_id}";
    }

    public static function mapErrorMessage(string $key): string
    {
        return match ($key) {
            'access_token_expired' => __('mixpost::account.access_token_expired'),
            'upload_failed' => __('mixpost::service.twitter.upload_failed'),
            'request_timeout' => __('mixpost::error.request_timeout'),
            'unknown_error' => __('mixpost::error.unknown_error'),
            'video_not_selected' => __('mixpost::post.video_not_selected'),
            default => $key
        };
    }
}
