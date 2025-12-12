<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

use DateTimeImmutable;

class Bucket
{
    public function __construct(
        public readonly string $name,
        public readonly DateTimeImmutable $creationDate,
        public readonly ?string $location = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['Name'],
            creationDate: new DateTimeImmutable($data['CreationDate']),
            location: $data['LocationConstraint'] ?? null,
        );
    }
}
