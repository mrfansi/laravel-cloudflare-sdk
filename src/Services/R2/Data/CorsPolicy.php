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
        // Required fields are always included
        $data = [
            'AllowedOrigins' => $this->allowedOrigins,
            'AllowedMethods' => $this->allowedMethods,
        ];

        // Optional fields are only included if non-null
        if ($this->allowedHeaders !== null) {
            $data['AllowedHeaders'] = $this->allowedHeaders;
        }

        if ($this->maxAgeSeconds !== null) {
            $data['MaxAgeSeconds'] = $this->maxAgeSeconds;
        }

        if ($this->exposeHeaders !== null) {
            $data['ExposeHeaders'] = $this->exposeHeaders;
        }

        return $data;
    }
}
