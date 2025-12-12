<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\Bucket;

beforeEach(function () {
    if (! env('CLOUDFLARE_ACCOUNT_ID') || ! env('CLOUDFLARE_API_TOKEN')) {
        $this->markTestSkipped('Cloudflare credentials not available.');
    }

    // Ensure we are using the real config from env
    config(['cloudflare-sdk.account_id' => env('CLOUDFLARE_ACCOUNT_ID')]);
    config(['cloudflare-sdk.api_token' => env('CLOUDFLARE_API_TOKEN')]);

    // Disable mocking
    Http::preventStrayRequests(false);
});

it('can perform real bucket operations', function () {
    $bucketName = 'sdk-test-'.strtolower(str()->random(8));

    // 1. Create
    $bucket = Cloudflare::r2()->buckets()->create($bucketName);
    expect($bucket)->toBeInstanceOf(Bucket::class)
        ->and($bucket->name)->toBe($bucketName);

    // 2. Get
    $fetchedBucket = Cloudflare::r2()->buckets()->get($bucketName);
    expect($fetchedBucket)->toBeInstanceOf(Bucket::class)
        ->and($fetchedBucket->name)->toBe($bucketName);

    // 3. List (verify existence)
    $paginator = Cloudflare::r2()->buckets()->list();
    $found = collect($paginator->items)->contains(fn (Bucket $b) => $b->name === $bucketName);
    expect($found)->toBeTrue();

    // 3. Get
    $fetched = Cloudflare::r2()->buckets()->get($bucketName);
    expect($fetched->name)->toBe($bucketName);

    // 4. Delete
    Cloudflare::r2()->buckets()->delete($bucketName);

    // 5. Verify Deletion (Get should fail or List should not find it)
    // Note: R2 deletion might have eventual consistency, but usually 404 immediately on GET
    try {
        Cloudflare::r2()->buckets()->get($bucketName);
        $exists = true;
    } catch (\Exception $e) {
        $exists = false;
    }
    expect($exists)->toBeFalse();
})->group('live');
