<?php

arch('r2 services are isolated')
    ->expect('Mrfansi\LaravelCloudflareSdk\Services\R2')
    ->toUseStrictTypes()
    ->not->toUse('Illuminate\Support\Facades\Cloudflare');

arch('r2 services do not depend on main sdk class')
    ->expect('Mrfansi\LaravelCloudflareSdk\Services\R2')
    ->not->toUse('Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdk');
