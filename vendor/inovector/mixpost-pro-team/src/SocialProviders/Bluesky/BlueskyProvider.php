<?php

namespace Inovector\Mixpost\SocialProviders\Bluesky;

use Inovector\Mixpost\Abstracts\SocialProvider;
use Inovector\Mixpost\Services\Bluesky\BlueskyService;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\HasExternalPostUrl;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\ManagesAccount;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\ManagesConfig;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\ManagesMetrics;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\ManagesOAuth;
use Inovector\Mixpost\SocialProviders\Bluesky\Concerns\ManagesPost;

class BlueskyProvider extends SocialProvider
{
    use ManagesConfig;
    use HasExternalPostUrl;
    use ManagesOAuth;
    use ManagesAccount;
    use ManagesPost;
    use ManagesMetrics;

    public const DEFAULT_SERVER = 'https://bsky.social';

    public array $callbackResponseKeys = ['code'];

    public static function service(): string
    {
        return BlueskyService::class;
    }
}
