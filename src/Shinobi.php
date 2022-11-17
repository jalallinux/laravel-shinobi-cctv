<?php

namespace JalalLinuX\Shinobi;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use JalalLinuX\Shinobi\Features\ApiKey;
use JalalLinuX\Shinobi\Features\Auth;
use JalalLinuX\Shinobi\Features\Monitor;
use JalalLinuX\Shinobi\Features\Stream;
use JalalLinuX\Shinobi\Features\SuperAdmin;
use JalalLinuX\Shinobi\Features\Video;

class Shinobi
{
    private ?string $groupKey = null;
    private PendingRequest $httpClient;
    private ?string $token = null;

    public function __construct(string $token = null, string $groupKey = null)
    {
        $this->setToken($token);
        $this->setGroupKey($groupKey);
        $this->httpClient = Http::baseUrl($this->makeUrl())->timeout(5)->connectTimeout(5);
    }

    public static function as(string $mail, string $pass): Shinobi
    {
        return new Shinobi(...(new self)->auth()->login($mail, $pass)->only(['auth_token', 'ke'])->values());
    }

    public function makeUrl(string $path = ''): string
    {
        $baseUrl = $this->config('base_uri');
        throw_if(is_null($baseUrl), $this->throw("Base Uri is requried."));
        if (!str_ends_with($baseUrl, '/')) {
            $baseUrl .= '/';
        }
        return "{$baseUrl}{$path}";
    }

    private function throw(string $message, int $code = 500): \Exception
    {
        return new \Exception($message, $code);
    }

    public function getHttpClient(): PendingRequest
    {
        return $this->httpClient;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): Shinobi
    {
        $token = $token ?? $this->config('api_token');
        throw_if(is_null($token), $this->throw("API Token is requried."));
        $this->token = $token;
        return $this;
    }

    public function getGroupKey(): ?string
    {
        return $this->groupKey;
    }

    public function getSuperApiToken(): string
    {
        throw_if(is_null($token = $this->config('super_api_token')), new \Exception("Super API Key is required."));
        return $token;
    }

    public function setGroupKey(?string $groupKey): Shinobi
    {
        $this->groupKey = $groupKey ?? $this->config('group_key');
        return $this;
    }

    public function config(string $key = null)
    {
        $key = !is_null($key) ? ".{$key}" : "";
        return config("shinobi{$key}");
    }

    /**********************************
     *****   Feature Functions    *****
     **********************************/

    public function monitors(): Monitor
    {
        return new Monitor($this);
    }

    public function superAdmin(): SuperAdmin
    {
        return new SuperAdmin($this);
    }

    public function auth(): Auth
    {
        return new Auth($this);
    }

    public function apiKey(): ApiKey
    {
        return new ApiKey($this);
    }

    public function video(): Video
    {
        return new Video($this);
    }

    public function stream(): Stream
    {
        return new Stream($this);
    }
}
