<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\Bucket;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\BucketCursorPaginator;

beforeEach(function () {
    config(['cloudflare-sdk.r2.account_id' => 'test-account']);
    config(['cloudflare-sdk.r2.api_token' => 'test-token']);
});

it('can list buckets', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets*' => Http::response([
            'result' => [
                'buckets' => [
                    [
                        'Name' => 'test-bucket',
                        'CreationDate' => '2023-01-01T00:00:00Z',
                    ],
                ],
            ],
            'result_info' => ['cursor' => 'next-cursor'],
        ]),
    ]);

    $paginator = Cloudflare::r2()->buckets()->list();

    expect($paginator)->toBeInstanceOf(BucketCursorPaginator::class);
    expect($paginator->items)->toHaveCount(1);
    expect($paginator->items[0])->toBeInstanceOf(Bucket::class);
    expect($paginator->items[0]->name)->toBe('test-bucket');
    expect($paginator->nextCursor)->toBe('next-cursor');
});

it('can create a bucket', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets' => Http::response([
            'result' => [
                'Name' => 'new-bucket',
                'CreationDate' => '2023-01-01T00:00:00Z',
            ],
        ]),
    ]);

    $bucket = Cloudflare::r2()->buckets()->create('new-bucket');

    expect($bucket)->toBeInstanceOf(Bucket::class);
    expect($bucket->name)->toBe('new-bucket');
});

it('can get a bucket', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket' => Http::response([
            'result' => [
                'Name' => 'my-bucket',
                'CreationDate' => '2023-01-01T00:00:00Z',
            ],
        ]),
    ]);

    $bucket = Cloudflare::r2()->buckets()->get('my-bucket');

    expect($bucket)->toBeInstanceOf(Bucket::class);
    expect($bucket->name)->toBe('my-bucket');
});

it('can delete a bucket', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket' => Http::response(null, 200),
    ]);

    Cloudflare::r2()->buckets()->delete('my-bucket');

    Http::assertSent(function ($request) {
        return $request->method() === 'DELETE' &&
               $request->url() === 'https://api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket';
    });
});
