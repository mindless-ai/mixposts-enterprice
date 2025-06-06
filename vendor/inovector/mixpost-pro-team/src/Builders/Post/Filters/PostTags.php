<?php

namespace Inovector\Mixpost\Builders\Post\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Inovector\Mixpost\Contracts\Filter;

class PostTags implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('tags', function ($query) use ($value) {
            $query->whereIn('tag_id', Arr::wrap($value));
        });
    }
}
