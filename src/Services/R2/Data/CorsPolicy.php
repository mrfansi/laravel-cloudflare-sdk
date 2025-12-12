<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

class CorsPolicy
{
    /**
     * @param  array<string>  $allowedOrigins
     * @param  array<string>  $allowedMethods
     * @param  array<string>|null  $allowedHeaders
     * @param  array<string>|null  $exposeHeaders
     */
    public function __construct(
        public readonly array $allowedOrigins,
        public readonly array $allowedMethods,
        public readonly ?array $allowedHeaders = null,
        public readonly ?int $maxAgeSeconds = null,
        public readonly ?array $exposeHeaders = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            allowedOrigins: $data['AllowedOrigins'] ?? [],
            allowedMethods: $data['AllowedMethods'] ?? [],
            allowedHeaders: $data['AllowedHeaders'] ?? null,
            maxAgeSeconds: $data['MaxAgeSeconds'] ?? null,
            exposeHeaders: $data['ExposeHeaders'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'AllowedOrigins' => $this->allowedOrigins,
            'AllowedMethods' => $this->allowedMethods,
            'AllowedHeaders' => $this->allowedHeaders,
            'MaxAgeSeconds' => $this->maxAgeSeconds,
            'ExposeHeaders' => $this->exposeHeaders,
        ], fn ($v) => ! is_null($v));
    }
}
