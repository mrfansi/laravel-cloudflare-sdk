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
            id: $data['id'] ?? null,
            status: $data['status'],
            prefix: $data['prefix'] ?? null,
            expiration: $data['expiration'] ?? null,
            abortMultipartUpload: $data['abort_incomplete_multipart_upload'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'status' => $this->status,
            'prefix' => $this->prefix,
            'expiration' => $this->expiration,
            'abort_incomplete_multipart_upload' => $this->abortMultipartUpload,
        ], fn ($v) => ! is_null($v));
    }
}
