<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

class LifecycleRule
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $status,
        public readonly ?string $prefix = null,
        public readonly ?array $expiration = null,
        public readonly ?array $abortMultipartUpload = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['ID'] ?? null,
            status: $data['Status'],
            prefix: $data['Prefix'] ?? null,
            expiration: $data['Expiration'] ?? null,
            abortMultipartUpload: $data['AbortIncompleteMultipartUpload'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'ID' => $this->id,
            'Status' => $this->status,
            'Prefix' => $this->prefix,
            'Expiration' => $this->expiration,
            'AbortIncompleteMultipartUpload' => $this->abortMultipartUpload,
        ], fn($v) => !is_null($v));
    }
}
