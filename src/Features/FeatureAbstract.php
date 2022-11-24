<?php

namespace JalalLinuX\Shinobi\Features;

use JalalLinuX\Shinobi\Shinobi;

abstract class FeatureAbstract
{
    protected Shinobi $shinobi;

    public function __construct(Shinobi $shinobi)
    {
        $this->shinobi = $shinobi;
        throw_if(is_null($shinobi->getGroupKey()) && $this->groupKeyRequired(), new \Exception('GroupKey is required.'));
    }

    protected function groupKeyRequired(): bool
    {
        return true;
    }
}
