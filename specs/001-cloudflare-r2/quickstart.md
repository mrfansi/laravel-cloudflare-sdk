# Quickstart: R2 Integration

## Prerequisites

-   Cloudflare API Token with R2 Admin permissions.
-   Account ID configured in `.env`.

## Managing Buckets

```php
// List buckets (auto-paginated)
$paginator = Cloudflare::r2()->buckets()->list();
foreach ($paginator->items() as $bucket) {
    echo $bucket->name;
}

// Create a bucket in Western North America
$bucket = Cloudflare::r2()->buckets()->create('my-app-assets', 'wnam');

// Delete
Cloudflare::r2()->buckets()->delete('my-app-assets');
```

## CORS & Domains

```php
use Mrfansi\LaravelCloudflareSdk\R2\CorsPolicy;

// Enable CORS for web apps
Cloudflare::r2()->buckets()
    ->cors('my-app-assets')
    ->update(new CorsPolicy([
        'allowed_origins' => ['https://myapp.com'],
        'allowed_methods' => ['GET', 'PUT'],
    ]));

// Connect a custom domain
Cloudflare::r2()->buckets()
    ->domains('my-app-assets')
    ->add('assets.myapp.com');
```

## Error Handling

All methods throw `Illuminate\Http\Client\RequestException` on failure.

```php
use Illuminate\Http\Client\RequestException;

try {
    Cloudflare::r2()->buckets()->get('non-existent');
} catch (RequestException $e) {
    // Handle error, e.g. check for 404:
    if ($e->response->status() === 404) {
        // Handle not found
    }
}
```
