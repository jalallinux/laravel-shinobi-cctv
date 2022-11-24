<?php

namespace JalalLinuX\Shinobi\Features\SuperAdmin;

use Illuminate\Support\Collection;
use JalalLinuX\Shinobi\Features\FeatureAbstract;

class Log extends FeatureAbstract
{
    protected function groupKeyRequired(): bool
    {
        return false;
    }

    public function list(): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("super/{$this->shinobi->getSuperApiToken()}/logs");

        return $response->throw()->collect('logs');
    }

    public function delete(): bool
    {
        $response = $this->shinobi->getHttpClient()->delete("super/{$this->shinobi->getSuperApiToken()}/logs/delete");

        return (bool) $response->throw()->json('ok');
    }
}
