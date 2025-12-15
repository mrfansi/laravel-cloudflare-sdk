<?php

use Mrfansi\LaravelCloudflareSdk\Facades\LaravelCloudflareSdk;

test('can paginate buckets', function () {
    $r2 = LaravelCloudflareSdk::r2();
    $prefix = 'sdk-test-pagination-'.bin2hex(random_bytes(4));

    // Create 3 buckets
    $buckets = [
        "{$prefix}-1",
        "{$prefix}-2",
        "{$prefix}-3",
    ];

    foreach ($buckets as $bucketName) {
        $r2->buckets()->create($bucketName);
    }

    try {
        // List first page (limit 2)
        // Note: We use nameContains to filter only our test buckets
        $page1 = $r2->buckets()->list(nameContains: $prefix, limit: 2);

        expect($page1->items)->toHaveCount(2)
            ->and($page1->nextCursor)->not->toBeNull();

        // List second page
        $page2 = $r2->buckets()->list(cursor: $page1->nextCursor, nameContains: $prefix, limit: 2);

        expect($page2->items)->toHaveCount(1)
            ->and($page2->items->first()->name)->toBe("{$prefix}-3");

    } finally {
        // Cleanup
        foreach ($buckets as $bucketName) {
            try {
                $r2->buckets()->delete($bucketName);
            } catch (\Exception $e) {
                // Ignore cleanup errors
            }
        }
    }
})->group('integration');
