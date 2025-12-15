<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2;

use Illuminate\Http\Client\PendingRequest;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\Bucket;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\BucketCursorPaginator;

class R2BucketService
{
    public function __construct(
        protected PendingRequest $client,
    ) {}

    public function list(?string $cursor = null, ?string $nameContains = null, ?string $startAfter = null, ?int $limit = null): BucketCursorPaginator
    {
        $response = $this->client->get('buckets', array_filter([
            'cursor' => $cursor,
            'name_contains' => $nameContains,
            'start_after' => $startAfter,
            'per_page' => $limit,
        ]));

        $response->throw();

        $data = $response->json();

        $buckets = collect($data['result']['buckets'] ?? [])
            ->map(fn (array $bucket) => Bucket::fromArray($bucket));

        return new BucketCursorPaginator(
            items: $buckets,
            nextCursor: $data['result_info']['cursor'] ?? null,
        );
    }

    public function create(string $name, ?string $locationHint = null): Bucket
    {
        $data = ['name' => $name];
        if ($locationHint) {
            $data['locationHint'] = $locationHint;
        }

        $response = $this->client->post('buckets', $data);

        $response->throw();

        return Bucket::fromArray($response->json('result'));
    }

    public function get(string $name): Bucket
    {
        $response = $this->client->get("buckets/{$name}");

        $response->throw();

        return Bucket::fromArray($response->json('result'));
    }

    public function delete(string $name): void
    {
        $this->client->delete("buckets/{$name}")->throw();
    }

    public function cors(string $bucketName): R2CorsService
    {
        return new R2CorsService($this->client, $bucketName);
    }

    public function lifecycle(string $bucketName): R2LifecycleService
    {
        return new R2LifecycleService($this->client, $bucketName);
    }

    public function domains(string $bucketName): R2DomainService
    {
        return new R2DomainService($this->client, $bucketName);
    }
}
