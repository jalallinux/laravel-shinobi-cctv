<?php

namespace JalalLinuX\Shinobi\Features;

use Illuminate\Support\Collection;

class Auth extends FeatureAbstract
{
    public function login(string $mail, string $pass): Collection
    {
        $response = $this->shinobi->getHttpClient()->post('/?json=true', [
            'mail' => $mail, 'pass' => $pass,
        ]);

        return $response->throw()->collect('$user')->except(['lang']);
    }
}
