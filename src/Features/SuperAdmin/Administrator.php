<?php

namespace JalalLinuX\Shinobi\Features\SuperAdmin;

use Illuminate\Support\Collection;
use JalalLinuX\Shinobi\Features\FeatureAbstract;

class Administrator extends FeatureAbstract
{
    protected function groupKeyRequired(): bool
    {
        return false;
    }

    public function list(): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("super/{$this->shinobi->getSuperApiToken()}/accounts/list");

        return $response->throw()->collect('users');
    }

    public function add(string $mail, string $pass, string $groupKey, array $details)
    {
        $response = $this->shinobi->getHttpClient()->post("super/{$this->shinobi->getSuperApiToken()}/accounts/registerAdmin", ['data' => [
            'mail' => $mail,
            'pass' => $pass,
            'pass_again' => $pass,
            'ke' => $groupKey,
            'details' => $details,
        ]]);

        return $response->throw()->collect('user');
    }

    public function update(string $mail, string $groupKey, string $uid, string $newMail, string $newPass, string $newGroupKey, array $newDetails): bool
    {
        $response = $this->shinobi->getHttpClient()->put("super/{$this->shinobi->getSuperApiToken()}/accounts/editAdmin", [
            'account' => [
                'mail' => $mail,
                'ke' => $groupKey,
                'uid' => $uid,
            ],
            'data' => [
                'mail' => $newMail,
                'pass' => $newPass,
                'pass_again' => $newPass,
                'ke' => $newGroupKey,
                'details' => $newDetails,
            ],
        ]);

        return (bool) $response->throw()->json('ok');
    }

    public function delete(string $mail, string $groupKey, string $uid, bool $deleteSubAccounts = true, bool $deleteMonitors = true, bool $deleteVideos = true, bool $deleteEvents = true): bool
    {
        $response = $this->shinobi->getHttpClient()->delete("super/{$this->shinobi->getSuperApiToken()}/accounts/deleteAdmin", [
            'account' => [
                'mail' => $mail,
                'ke' => $groupKey,
                'uid' => $uid,
            ],
            'deleteSubAccounts' => $deleteSubAccounts ? '1' : '0',
            'deleteMonitors' => $deleteMonitors ? '1' : '0',
            'deleteVideos' => $deleteVideos ? '1' : '0',
            'deleteEvents' => $deleteEvents ? '1' : '0',
        ]);

        return (bool) $response->throw()->json('ok');
    }
}
