<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\CorsPolicy;

beforeEach(function () {
    config(['cloudflare-sdk.account_id' => 'test-account']);
    config(['cloudflare-sdk.api_token' => 'test-token']);
});

it('runs quickstart scenarios', function () {
    Http::fake(function ($request) {
        $url = $request->url();
        $method = $request->method();

        if ($url === 'https://api.cloudflare.com/client/v4/accounts/test-account/r2/buckets' && $method === 'GET') {
            return Http::response([
                'result' => [
                    'buckets' => [
                        ['name' => 'bucket-1', 'creation_date' => '2023-01-01T00:00:00Z'],
                        ['name' => 'bucket-2', 'creation_date' => '2023-01-01T00:00:00Z'],
                    ],
                ],
                'result_info' => ['cursor' => null],
            ]);
        }

        if ($url === 'https://api.cloudflare.com/client/v4/accounts/test-account/r2/buckets' && $method === 'POST') {
            return Http::response([
                'result' => ['name' => 'my-app-assets', 'creation_date' => '2023-01-01T00:00:00Z'],
            ]);
        }

        if (str_contains($url, '/buckets/my-app-assets/cors')) {
            return Http::response(null, 200);
        }

        if (str_contains($url, '/buckets/my-app-assets/domains/custom')) {
            return Http::response(null, 200);
        }

        if (str_contains($url, '/buckets/my-app-assets')) {
            return Http::response(null, 200);
        }

        return Http::response(null, 404);
    });

    // List buckets
    $paginator = Cloudflare::r2()->buckets()->list();
    $names = [];
    foreach ($paginator->items() as $bucket) {
        $names[] = $bucket->name;
    }
    expect($names)->toBe(['bucket-1', 'bucket-2']);

    // Create bucket
    $bucket = Cloudflare::r2()->buckets()->create('my-app-assets', 'wnam');
    expect($bucket->name)->toBe('my-app-assets');

    // Delete bucket
    Cloudflare::r2()->buckets()->delete('my-app-assets');

    // Update CORS
    Cloudflare::r2()->buckets()->cors('my-app-assets')->update(new CorsPolicy(
        allowedOrigins: ['https://myapp.com'],
        allowedMethods: ['GET', 'PUT'],
    ));

    // Add Domain
    Cloudflare::r2()->buckets()
        ->domains('my-app-assets')
        ->add('assets.myapp.com');
});
