<?php

use Illuminate\Support\Facades\Route;
use Inovector\Mixpost\Enums\WorkspaceUserRole;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\AccountsController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\MediaController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\MediaUploadFileController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\Post\AddPostToQueueController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\Post\ApprovePostController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\Post\DeletePostsController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\Post\PostsController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\Post\SchedulePostController;
use Inovector\Mixpost\Http\Api\Controllers\Workspace\TagsController;
use Inovector\Mixpost\Http\Base\Middleware\CheckWorkspaceUser;
use Inovector\Mixpost\Http\Base\Middleware\IdentifyWorkspace;
use Inovector\Mixpost\Mixpost;

Route::middleware(array_merge([
    IdentifyWorkspace::class,
    CheckWorkspaceUser::class
], Mixpost::getWorkspaceMiddlewares()))
    ->prefix('{workspace}')
    ->group(function () {
        $editorMiddleware = CheckWorkspaceUser::class . ':' . WorkspaceUserRole::ADMIN->name . '|' . WorkspaceUserRole::MEMBER->name;

        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AccountsController::class, 'index'])->name('index');
            Route::get('{account}', [AccountsController::class, 'show'])->name('show');
        });

        Route::prefix('posts')->name('posts.')->middleware($editorMiddleware)->group(function () use($editorMiddleware) {
            Route::get('/', [PostsController::class, 'index'])->name('index')->withoutMiddleware($editorMiddleware);
            Route::post('/', [PostsController::class, 'store'])->name('store');
            Route::get('{post}', [PostsController::class, 'show'])->name('show')->withoutMiddleware($editorMiddleware);
            Route::put('{post}', [PostsController::class, 'update'])->name('update');
            Route::delete('{post}', [PostsController::class, 'destroy'])->name('delete');
            Route::delete('/', DeletePostsController::class)->name('deleteMultiple');

            Route::post('schedule/{post}', SchedulePostController::class)->name('schedule');
            Route::post('add-to-queue/{post}', AddPostToQueueController::class)->name('addToQueue');
            Route::post('approve/{post}', ApprovePostController::class)->name('approve')->withoutMiddleware($editorMiddleware);
        });

        Route::prefix('media')->name('media.')->middleware($editorMiddleware)->group(function () use($editorMiddleware) {
            Route::get('/', [MediaController::class, 'index'])->name('index')->withoutMiddleware($editorMiddleware);
            Route::get('{media}', [MediaController::class, 'show'])->name('show')->withoutMiddleware($editorMiddleware);
            Route::post('/', MediaUploadFileController::class)->name('upload');
            Route::delete('/', [MediaController::class, 'destroy'])->name('delete');
        });

        Route::prefix('tags')->name('tags.')->middleware($editorMiddleware)->group(function () {
            Route::get('/', [TagsController::class, 'index'])->name('index');
            Route::post('/', [TagsController::class, 'store'])->name('store');
            Route::get('{tag}', [TagsController::class, 'show'])->name('show');
            Route::put('{tag}', [TagsController::class, 'update'])->name('update');
            Route::delete('{tag}', [TagsController::class, 'destroy'])->name('delete');
        });
    });
