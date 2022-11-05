<?php

namespace JalalLinuX\Shinobi\Features;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class Video extends FeatureAbstract
{
    public function list(): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}");
        return $response->throw()->collect('videos');
    }

    public function monitor(string $monitorId): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}/{$monitorId}");
        return $response->throw()->collect('videos');
    }

    public function download(string $monitorId, string $filename): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}/{$monitorId}/{$filename}");
        return $response->throw();
    }

    public function delete(string $monitorId, string $filename): bool
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}/{$monitorId}/{$filename}/delete");
        return !!$response->throw()->json('ok');
    }

    public function markAsRead(string $monitorId, string $filename): bool
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}/{$monitorId}/{$filename}/status/1");
        return !!$response->throw()->json('ok');
    }

    public function markAsUnRead(string $monitorId, string $filename): bool
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/videos/{$this->shinobi->getGroupKey()}/{$monitorId}/{$filename}/status/2");
        return !!$response->throw()->json('ok');
    }
}
