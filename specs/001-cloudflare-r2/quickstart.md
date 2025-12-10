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
$bucket = Cloudflare::r2()->buckets()->create([
    'name' => 'my-app-assets',
    'location' => 'wnam'
]);

// Delete
Cloudflare::r2()->buckets()->delete('my-app-assets');
```

## CORS & Domains

```php
// Enable CORS for web apps
Cloudflare::r2()->buckets()->updateCors('my-app-assets', [
    'allowed_origins' => ['https://myapp.com'],
    'allowed_methods' => ['GET', 'PUT'],
]);

// Connect a custom domain
Cloudflare::r2()->buckets()
    ->domains('my-app-assets')
    ->add('assets.myapp.com');
```

## Error Handling

All methods throw `Mrfansi\LaravelCloudflareSdk\Exceptions\CloudflareSdkException` on failure.

```php
try {
    Cloudflare::r2()->buckets()->get('non-existent');
} catch (BucketNotFoundException $e) {
    // Handle 404
}
```
