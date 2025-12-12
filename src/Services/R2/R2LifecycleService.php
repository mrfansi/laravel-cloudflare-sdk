<?php

declare(strict_types=1);

namespace Mrfansi\LaravelCloudflareSdk\Services\R2;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Mrfansi\LaravelCloudflareSdk\Services\R2\Data\LifecycleRule;

class R2LifecycleService
{
    public function __construct(
        protected PendingRequest $client,
        protected string $bucketName,
    ) {}

    /**
     * @return Collection<int, LifecycleRule>
     */
    public function get(): Collection
    {
        $response = $this->client->get("buckets/{$this->bucketName}/lifecycle");

        if ($response->notFound()) {
            return collect([]);
        }

        $response->throw();

        return collect($response->json('result.rules') ?? [])
            ->map(fn (array $rule) => LifecycleRule::fromArray($rule));
    }

    /**
     * @param array<LifecycleRule> $rules
     */
    public function update(array $rules): void
    {
        $data = [
            'rules' => collect($rules)->map(fn (LifecycleRule $rule) => $rule->toArray())->all(),
        ];

        $this->client->put("buckets/{$this->bucketName}/lifecycle", $data)->throw();
    }
}
