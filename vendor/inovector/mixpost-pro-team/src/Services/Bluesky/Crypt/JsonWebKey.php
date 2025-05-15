<?php

namespace Inovector\Mixpost\Services\Bluesky\Crypt;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Traits\Tappable;
use Inovector\Mixpost\Services\Bluesky\Crypt\PrivateKey as LocalPrivateKey;
use phpseclib3\Crypt\EC\Formats\Keys\PKCS8;
use phpseclib3\Crypt\EC\PrivateKey;
use phpseclib3\Crypt\EC\PublicKey;
use Stringable;

final class JsonWebKey implements Arrayable, Jsonable, Stringable
{
    use Tappable;

    protected string $kid = 'illuminate';

    public function __construct(protected PrivateKey|PublicKey $key)
    {
        //
    }

    public function key(): PublicKey|PrivateKey
    {
        return $this->key;
    }

    public function kid(): string
    {
        return $this->kid;
    }

    public function withKid(string $kid): self
    {
        $this->kid = $kid;

        return $this;
    }

    public function asPublic(): self
    {
        if ($this->key instanceof PublicKey) {
            return $this;
        }

        $clone = clone $this;
        $clone->key = $this->key->getPublicKey();

        return $clone;
    }

    public function toPEM(): string
    {
        return $this->key->toString(class_basename(PKCS8::class));
    }

    public function toArray(): array
    {
        return data_get(json_decode($this->key->toString('JWK', [
            'kid' => $this->kid,
            'alg' => LocalPrivateKey::ALG,
            'use' => 'sig',
        ]), true), 'keys.0', []);
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options | JSON_THROW_ON_ERROR);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
