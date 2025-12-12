<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\Domain;

class R2DomainService
{
    public function __construct(
        protected PendingRequest $client,
        protected string $bucketName,
    ) {}

    /**
     * @return Collection<int, Domain>
     */
    public function list(): Collection
    {
        $response = $this->client->get("buckets/{$this->bucketName}/domains");

        $response->throw();

        return collect($response->json('result.domains') ?? [])
            ->map(fn (array $domain) => Domain::fromArray($domain));
    }

    public function add(string $domain): void
    {
        $this->client->put("buckets/{$this->bucketName}/domains/custom", [
            'domain' => $domain,
            'enabled' => true,
        ])->throw();
    }

    public function remove(string $domain): void
    {
        $this->client->delete("buckets/{$this->bucketName}/domains/custom", [
            'domain' => $domain,
        ])->throw();
    }
}
