<?php

namespace JalalLinuX\Shinobi\Commands;

use Illuminate\Console\Command;
use JalalLinuX\Shinobi\Shinobi;

class ShinobiCommand extends Command
{
    public $signature = 'shinobi:monitor-mode';

    public $description = 'Change monitor mode {monitor_id} {mode}';

    public function handle(Shinobi $shinobi): int
    {
        return $shinobi->monitors()->mode($this->argument('monitor_id'), $this->argument('mode'));
    }
}
