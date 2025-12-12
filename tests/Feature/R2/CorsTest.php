<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\CorsPolicy;

beforeEach(function () {
    config(['cloudflare-sdk.r2.account_id' => 'test-account']);
    config(['cloudflare-sdk.r2.api_token' => 'test-token']);
});

it('can get cors policy', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/cors' => Http::response([
            'result' => [
                'AllowedOrigins' => ['*'],
                'AllowedMethods' => ['GET'],
            ],
        ]),
    ]);

    $policy = Cloudflare::r2()->buckets()->cors('my-bucket')->get();

    expect($policy)->toBeInstanceOf(CorsPolicy::class);
    expect($policy->allowedOrigins)->toBe(['*']);
});

it('can update cors policy', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/cors' => Http::response(null, 200),
    ]);

    $policy = new CorsPolicy(
        allowedOrigins: ['*'],
        allowedMethods: ['GET'],
    );

    Cloudflare::r2()->buckets()->cors('my-bucket')->update($policy);

    Http::assertSent(function ($request) {
        return $request->method() === 'PUT' &&
               $request->url() === 'https://api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/cors' &&
               $request['AllowedOrigins'] === ['*'];
    });
});

it('can delete cors policy', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/cors' => Http::response(null, 200),
    ]);

    Cloudflare::r2()->buckets()->cors('my-bucket')->delete();

    Http::assertSent(function ($request) {
        return $request->method() === 'DELETE';
    });
});
