<?php

namespace Inovector\Mixpost\Events\Post;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Inovector\Mixpost\Contracts\ShouldReceivePostModel;
use Inovector\Mixpost\Contracts\WebhookEvent;
use Inovector\Mixpost\Http\Api\Resources\PostResource;
use Inovector\Mixpost\Models\Post;
use Inovector\Mixpost\Support\EagerLoadPostVersionsMedia;

class PostPublished implements WebhookEvent, ShouldReceivePostModel
{
    use Dispatchable, SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public static function name(): string
    {
        return 'post.published';
    }

    public static function nameLocalized(): string
    {
        return __('mixpost::webhook.event.post.published');
    }

    public function payload(): array
    {
        $this->post->load('accounts', 'versions', 'tags');

        EagerLoadPostVersionsMedia::apply($this->post);

        return (new PostResource($this->post))->resolve();
    }
}
