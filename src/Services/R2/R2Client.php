<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class R2Client
{
    public function __construct(
        protected string $accountId,
        protected string $apiToken,
    ) {}

    protected function makeRequest(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->baseUrl("https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/r2");
    }

    public function buckets(): R2BucketService
    {
        return new R2BucketService($this->makeRequest());
    }
}
