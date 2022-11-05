<?php

namespace JalalLinuX\Shinobi\Features;

use JalalLinuX\Shinobi\Features\SuperAdmin\Administrator;
use JalalLinuX\Shinobi\Features\SuperAdmin\Log;
use JalalLinuX\Shinobi\Features\SuperAdmin\Setting;

class SuperAdmin extends FeatureAbstract
{
    public function log(): Log
    {
        return new Log($this->shinobi);
    }

    public function administrator(): Administrator
    {
        return new Administrator($this->shinobi);
    }

    public function setting(): Setting
    {
        return new Setting($this->shinobi);
    }
}
