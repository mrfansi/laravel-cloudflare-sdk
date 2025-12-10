<?php

namespace Mrfansi\LaravelCloudflareSdk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdk
 */
class LaravelCloudflareSdk extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdk::class;
    }
}
