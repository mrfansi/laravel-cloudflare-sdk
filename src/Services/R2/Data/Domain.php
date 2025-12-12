<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

class Domain
{
    public function __construct(
        public readonly string $domain,
        public readonly bool $enabled,
        public readonly ?string $type = null,
        public readonly ?string $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            domain: $data['domain'],
            enabled: $data['enabled'],
            type: $data['type'] ?? null,
            status: $data['status'] ?? null,
        );
    }
}
