<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2\Data;

use Illuminate\Support\Collection;

class BucketCursorPaginator
{
    /**
     * @param  Collection<int, Bucket>  $items
     * @param  (\Closure(?string $cursor): BucketCursorPaginator)|null  $fetcher
     */
    public function __construct(
        public readonly Collection $items,
        public readonly ?string $nextCursor,
        private readonly ?\Closure $fetcher = null,
    ) {}

    /**
     * Fetch the next page of results, or null if there is no next page or fetcher is not set.
     */
    public function next(): ?BucketCursorPaginator
    {
        if ($this->nextCursor === null || $this->fetcher === null) {
            return null;
        }

        return call_user_func($this->fetcher, $this->nextCursor);
    }
}
