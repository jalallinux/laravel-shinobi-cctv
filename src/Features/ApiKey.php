<?php

namespace JalalLinuX\Shinobi\Features;

use Illuminate\Support\Collection;

class ApiKey extends FeatureAbstract
{
    public function list(): Collection
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/api/{$this->shinobi->getGroupKey()}/list");
        return $response->throw()->collect('keys');
    }

    public function add(string $ip, bool $authSocket = true, bool $getMonitors = true, bool $controlMonitors = true, bool $getLogs = true, bool $watchStream = true, bool $watchSnapshot = true, bool $watchVideos = true, bool $deleteVideos = true): Collection
    {
        $response = $this->shinobi->getHttpClient()->post("{$this->shinobi->getToken()}/api/{$this->shinobi->getGroupKey()}/add", [
            'data' => [
                'ip' => $ip,
                'details' => [
                    "auth_socket" => $authSocket ? "1" : "0",
                    "get_monitors" => $getMonitors ? "1" : "0",
                    "control_monitors" => $controlMonitors ? "1" : "0",
                    "get_logs" => $getLogs ? "1" : "0",
                    "watch_stream" => $watchStream ? "1" : "0",
                    "watch_snapshot" => $watchSnapshot ? "1" : "0",
                    "watch_videos" => $watchVideos ? "1" : "0",
                    "delete_videos" => $deleteVideos ? "1" : "0",
                ]
            ]
        ]);
        return $response->throw()->collect('api');
    }

    public function delete(string $token): bool
    {
        throw_if($this->shinobi->getToken() == $token, new \Exception("Can\'t delete current API Token."));
        $response = $this->shinobi->getHttpClient()->delete("{$this->shinobi->getToken()}/api/{$this->shinobi->getGroupKey()}/delete", [
            'data' => ['code' => $token]
        ]);
        return !!$response->throw()->json('ok');
    }
}
