<?php

namespace Mrfansi\LaravelCloudflareSdk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Mrfansi\LaravelCloudflareSdk\Services\R2\R2Client r2()
 *
 * @see \Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdk
 */
class Cloudflare extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdk::class;
    }
}
