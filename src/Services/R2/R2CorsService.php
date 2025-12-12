<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2;

use Illuminate\Http\Client\PendingRequest;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\CorsPolicy;

class R2CorsService
{
    public function __construct(
        protected PendingRequest $client,
        protected string $bucketName,
    ) {}

    public function get(): ?CorsPolicy
    {
        $response = $this->client->get("buckets/{$this->bucketName}/cors");

        if ($response->notFound()) {
            return null;
        }

        $response->throw();

        return CorsPolicy::fromArray($response->json('result'));
    }

    public function update(CorsPolicy $policy): void
    {
        $this->client->put("buckets/{$this->bucketName}/cors", $policy->toArray())->throw();
    }

    public function delete(): void
    {
        $this->client->delete("buckets/{$this->bucketName}/cors")->throw();
    }
}
