<?php

namespace JalalLinuX\Shinobi\Features;

use Illuminate\Support\Collection;
use JalalLinuX\Shinobi\Jobs\MonitorModeJob;

class Monitor extends FeatureAbstract
{
    public function list(): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/monitor/{$this->shinobi->getGroupKey()}");
        return $response->throw()->collect();
    }

    public function get(string $monitorId): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/monitor/{$this->shinobi->getGroupKey()}/{$monitorId}");
        return collect($response->throw()->collect()->first());
    }

    public function add(string $monitorId, array $config): bool
    {
        $response = $this->shinobi->getHttpClient()->post("{$this->shinobi->getToken()}/configureMonitor/{$this->shinobi->getGroupKey()}/{$monitorId}", ['data' => $config]);
        return !!$response->throw()->json('ok');
    }

    public function update(string $monitorId, array $config): bool
    {
        $response = $this->shinobi->getHttpClient()->put("{$this->shinobi->getToken()}/configureMonitor/{$this->shinobi->getGroupKey()}/{$monitorId}", ['data' => $config]);
        return !!$response->throw()->json('ok');
    }

    public function delete(string $monitorId): bool
    {
        $response = $this->shinobi->getHttpClient()->delete("{$this->shinobi->getToken()}/monitor/{$this->shinobi->getGroupKey()}/{$monitorId}/delete");
        return !!$response->throw()->json('ok');
    }

    public function mode(string $monitorId, string $mode): bool
    {
        throw_if(!in_array($mode, ['start', 'stop', 'record']), new \Exception("Monitor mode can be one of the following: start, stop, record."));
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/monitor/{$this->shinobi->getGroupKey()}/{$monitorId}/{$mode}");
        return !!$response->throw()->json('ok');
    }

    public function record(string $monitorId, \DateTime $start, \DateTime $end)
    {
        $this->get($monitorId);
        MonitorModeJob::dispatch($this->shinobi->getToken(), $this->shinobi->getGroupKey(), $monitorId, 'record')
            ->delay($start)->onConnection(config('shinobi.queue_connection', 'redis'));
        MonitorModeJob::dispatch($this->shinobi->getToken(), $this->shinobi->getGroupKey(), $monitorId, 'start')
            ->delay($end)->onConnection(config('shinobi.queue_connection', 'redis'));
    }

    public function iframe(string $monitorId, array $options = ['jquery', 'fullscreen']): string
    {
        return $this->shinobi->makeUrl("{$this->shinobi->getToken()}/embed/{$this->shinobi->getGroupKey()}/$monitorId/" . implode('|', $options));
    }
}
