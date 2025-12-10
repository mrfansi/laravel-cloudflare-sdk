<?php

namespace Mrfansi\LaravelCloudflareSdk\Commands;

use Illuminate\Console\Command;

class LaravelCloudflareSdkCommand extends Command
{
    public $signature = 'laravel-cloudflare-sdk';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
