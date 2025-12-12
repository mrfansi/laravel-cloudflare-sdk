<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

use Illuminate\Support\Collection;

class BucketCursorPaginator
{
    /**
     * @param  Collection<int, Bucket>  $items
     */
    public function __construct(
        public readonly Collection $items,
        public readonly ?string $nextCursor,
    ) {}

    public function items(): Collection
    {
        return $this->items;
    }
}
