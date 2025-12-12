<?php

namespace Mrfansi\LaravelCloudflareSdk\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mrfansi\LaravelCloudflareSdk\LaravelCloudflareSdkServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mrfansi\\LaravelCloudflareSdk\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelCloudflareSdkServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        if (file_exists(__DIR__.'/../.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/..');
            $dotenv->safeLoad();
        }

        config()->set('database.default', 'testing');
        
        $accountId = $_ENV['CLOUDFLARE_ACCOUNT_ID'] ?? getenv('CLOUDFLARE_ACCOUNT_ID');
        $apiToken = $_ENV['CLOUDFLARE_API_TOKEN'] ?? getenv('CLOUDFLARE_API_TOKEN');

        if (! $accountId || ! $apiToken) {
             // Fallback to reading .env manually if Dotenv didn't populate env/server
             $envPath = __DIR__.'/../.env';
             if (file_exists($envPath)) {
                 $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                 foreach ($lines as $line) {
                     if (str_starts_with($line, '#')) continue;
                     if (str_contains($line, '=')) {
                         list($name, $value) = explode('=', $line, 2);
                         $name = trim($name);
                         $value = trim($value, '"\'');
                         if ($name === 'CLOUDFLARE_ACCOUNT_ID') $accountId = $value;
                         if ($name === 'CLOUDFLARE_API_TOKEN') $apiToken = $value;
                     }
                 }
             }
        }

        config()->set('cloudflare-sdk.account_id', $accountId);
        config()->set('cloudflare-sdk.api_token', $apiToken);

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
