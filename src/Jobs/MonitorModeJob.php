<?php

namespace JalalLinuX\Shinobi\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JalalLinuX\Shinobi\Shinobi;

class MonitorModeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $token;
    private string $groupKey;
    private string $monitorId;
    private string $mode;

    /**
     * Create a new job instance.
     *
     * @return void
     * @throws \Throwable
     */
    public function __construct(string $token, string $groupKey, string $monitorId, string $mode)
    {
        throw_if(!in_array($mode, ['start', 'stop', 'record']), new \Exception("Monitor mode can be one of the following: start, stop, record."));
        $this->token = $token;
        $this->groupKey = $groupKey;
        $this->monitorId = $monitorId;
        $this->mode = $mode;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        return (new Shinobi($this->token, $this->groupKey))->monitors()->mode($this->monitorId, $this->mode);
    }
}
