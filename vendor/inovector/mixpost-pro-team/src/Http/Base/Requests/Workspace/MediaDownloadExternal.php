<?php

namespace Inovector\Mixpost\Http\Base\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Inovector\Mixpost\Abstracts\Image;
use Inovector\Mixpost\Concerns\UsesMediaPath;
use Inovector\Mixpost\Events\Media\UploadingMediaFile;
use Inovector\Mixpost\Integrations\Unsplash\Jobs\TriggerDownloadJob;
use Inovector\Mixpost\MediaConversions\MediaImageResizerConversion;
use Inovector\Mixpost\Support\File;
use Inovector\Mixpost\Support\MediaUploader;
use Inovector\Mixpost\Util;

class MediaDownloadExternal extends FormRequest
{
    use UsesMediaPath;

    public function rules(): array
    {
        return [
            'from' => ['required', 'string', 'in:stock,gifs'],
            'items' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {
                        $validKeys = ['id', 'url', 'source', 'author', 'download_data'];

                        $extraKeys = array_diff(array_keys($item), $validKeys);

                        if (!empty($extraKeys)) {
                            $fail('The ' . $attribute . ' item contains invalid keys: ' . implode(', ', $extraKeys));
                            break;
                        }

                        foreach (array_flip(Arr::except(array_flip($validKeys), ['source', 'author'])) as $key) {
                            if (empty($item[$key])) {
                                $fail('The ' . $attribute . ' item must have a non-empty "' . $key . '" key.');
                                break 2;
                            }
                        }

                        if (!Util::isPublicDomainUrl($item['url'])) {
                            $fail('The ' . $attribute . ' contains non-public domain URLs.');
                        }
                    }
                },
            ],
        ];
    }

    public function handle(): Collection
    {
        return collect($this->input('items'))->map(function ($item) {
            $response = File::fetchUrl($item['url']);

            if (!$response->successful()) {
                return null;
            }

            $file = File::fromBase64(
                base64File: base64_encode($response->body()),
                filename: File::getFilenameFromHttpResponse($response)
            );

            UploadingMediaFile::dispatch($file);

            $media = MediaUploader::fromFile($file)->path(self::mediaWorkspacePathWithDateSubpath())
                ->conversions([
                    MediaImageResizerConversion::name('thumb')->width(Image::MEDIUM_WIDTH)->height(Image::MEDIUM_HEIGHT),
                ])
                ->data($this->getData($item))
                ->uploadAndInsert();

            $method = 'downloadAction' . Str::studly($this->input('from'));

            $this->$method($item);

            return $media;
        })->filter();
    }

    protected function getData(array $item): array
    {
        $data = [];

        if (!empty($item['source'])) {
            $data['source'] = $item['source'];
        }

        if (!empty($item['author'])) {
            $data['author'] = $item['author'];
        }

        return $data;
    }

    protected function downloadActionStock(array $item): void
    {
        if (empty($item['download_data']['download_location'])) {
            return;
        }

        TriggerDownloadJob::dispatch($item['download_data']['download_location']);
    }

    protected function downloadActionGifs(array $item): void
    {

    }
}
