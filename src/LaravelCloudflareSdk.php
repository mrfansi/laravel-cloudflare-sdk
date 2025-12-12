<?php

namespace Mrfansi\LaravelCloudflareSdk;

use Mrfansi\LaravelCloudflareSdk\Services\R2\R2Client;

class LaravelCloudflareSdk
{
    public function r2(): R2Client
    {
        return new R2Client(
            accountId: config('cloudflare-sdk.account_id'),
            apiToken: config('cloudflare-sdk.api_token'),
        );
    }
}
