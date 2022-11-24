<?php

namespace JalalLinuX\Shinobi\Features\SuperAdmin;

use JalalLinuX\Shinobi\Features\FeatureAbstract;

class Setting extends FeatureAbstract
{
    protected function groupKeyRequired(): bool
    {
        return false;
    }

    public function update(array $details): bool
    {
        $response = $this->shinobi->getHttpClient()->put("super/{$this->shinobi->getSuperApiToken()}/accounts/saveSettings", [
            'data' => ['details' => $details],
        ]);

        return (bool) $response->throw()->json('ok');
    }

    public function password(string $mail, string $newPass): bool
    {
        $response = $this->shinobi->getHttpClient()->put("super/{$this->shinobi->getSuperApiToken()}/accounts/saveSettings", [
            'data' => ['mail' => $mail, 'pass' => $newPass, 'pass_again' => $newPass],
        ]);

        return (bool) $response->throw()->json('ok');
    }
}
