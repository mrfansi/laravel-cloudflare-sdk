<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\Domain;

beforeEach(function () {
    config(['cloudflare-sdk.r2.account_id' => 'test-account']);
    config(['cloudflare-sdk.r2.api_token' => 'test-token']);
});

it('can list domains', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/domains' => Http::response([
            'result' => [
                'domains' => [
                    [
                        'domain' => 'cdn.example.com',
                        'enabled' => true,
                    ]
                ]
            ]
        ]),
    ]);

    $domains = Cloudflare::r2()->buckets()->domains('my-bucket')->list();

    expect($domains)->toHaveCount(1);
    expect($domains[0])->toBeInstanceOf(Domain::class);
    expect($domains[0]->domain)->toBe('cdn.example.com');
});

it('can add a domain', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/domains/custom' => Http::response(null, 200),
    ]);

    Cloudflare::r2()->buckets()->domains('my-bucket')->add('cdn.example.com');

    Http::assertSent(function ($request) {
        return $request->method() === 'PUT' &&
               $request['domain'] === 'cdn.example.com';
    });
});

it('can remove a domain', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/domains/custom' => Http::response(null, 200),
    ]);

    Cloudflare::r2()->buckets()->domains('my-bucket')->remove('cdn.example.com');

    Http::assertSent(function ($request) {
        return $request->method() === 'DELETE' &&
               $request['domain'] === 'cdn.example.com';
    });
});
