<?php

namespace Mrfansi\LaravelCloudflareSdk;

use Mrfansi\LaravelCloudflareSdk\Services\R2\R2Client;

class LaravelCloudflareSdk
{
    public function r2(): R2Client
    {
        return new R2Client(
            accountId: config('cloudflare-sdk.r2.account_id'),
            apiToken: config('cloudflare-sdk.r2.api_token'),
        );
    }
}
