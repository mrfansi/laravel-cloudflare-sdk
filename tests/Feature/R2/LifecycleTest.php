<?php

use Illuminate\Support\Facades\Http;
use Mrfansi\LaravelCloudflareSdk\Facades\Cloudflare;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\LifecycleRule;

beforeEach(function () {
    config(['cloudflare-sdk.account_id' => 'test-account']);
    config(['cloudflare-sdk.api_token' => 'test-token']);
});

it('can get lifecycle rules', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/lifecycle' => Http::response([
            'result' => [
                'rules' => [
                    [
                        'id' => 'rule-1',
                        'status' => 'Enabled',
                        'prefix' => 'logs/',
                        'expiration' => [
                            'days' => 30,
                        ],
                    ],
                    [
                        'id' => 'rule-2',
                        'status' => 'Disabled',
                        'abort_incomplete_multipart_upload' => [
                            'days_after_initiation' => 7,
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $rules = Cloudflare::r2()->buckets()->lifecycle('my-bucket')->get();

    expect($rules)->toHaveCount(2);
    expect($rules[0])->toBeInstanceOf(LifecycleRule::class);
    expect($rules[0]->id)->toBe('rule-1');
    expect($rules[0]->status)->toBe('Enabled');
    expect($rules[0]->prefix)->toBe('logs/');
    expect($rules[0]->expiration)->toBe(['days' => 30]);
    expect($rules[1]->id)->toBe('rule-2');
    expect($rules[1]->status)->toBe('Disabled');
    expect($rules[1]->abortMultipartUpload)->toBe(['days_after_initiation' => 7]);
});

it('returns empty collection when no lifecycle rules exist', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/lifecycle' => Http::response(null, 404),
    ]);

    $rules = Cloudflare::r2()->buckets()->lifecycle('my-bucket')->get();

    expect($rules)->toHaveCount(0);
    expect($rules)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('can update lifecycle rules', function () {
    Http::fake([
        'api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/lifecycle' => Http::response(null, 200),
    ]);

    $rule1 = new LifecycleRule(
        id: 'rule-1',
        status: 'Enabled',
        prefix: 'logs/',
        expiration: ['days' => 30],
    );

    $rule2 = new LifecycleRule(
        id: null,
        status: 'Enabled',
        prefix: 'temp/',
        expiration: ['days' => 7],
    );

    Cloudflare::r2()->buckets()->lifecycle('my-bucket')->update([$rule1, $rule2]);

    Http::assertSent(function ($request) {
        return $request->method() === 'PUT' &&
               $request->url() === 'https://api.cloudflare.com/client/v4/accounts/test-account/r2/buckets/my-bucket/lifecycle' &&
               isset($request['rules']) &&
               count($request['rules']) === 2 &&
               $request['rules'][0]['id'] === 'rule-1' &&
               $request['rules'][0]['status'] === 'Enabled' &&
               $request['rules'][0]['prefix'] === 'logs/' &&
               $request['rules'][1]['status'] === 'Enabled' &&
               $request['rules'][1]['prefix'] === 'temp/';
    });
});
