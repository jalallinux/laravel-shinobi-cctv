<?php

namespace JalalLinuX\Shinobi\Features;

use Illuminate\Http\Client\Response;

class Stream extends FeatureAbstract
{
    public function jpeg(string $monitorId): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/jpeg/{$this->shinobi->getGroupKey()}/{$monitorId}/s.jpg");
        return $response->throw();
    }

    public function mjpeg(string $monitorId): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/mjpeg/{$this->shinobi->getGroupKey()}/{$monitorId}?full=true");
        return $response->throw();
    }

    public function hls(string $monitorId): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/hls/{$this->shinobi->getGroupKey()}/{$monitorId}/s.m3u8");
        return $response->throw();
    }

    public function flv(string $monitorId): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/flv/{$this->shinobi->getGroupKey()}/{$monitorId}/s.flv");
        return $response->throw();
    }

    public function mp4(string $monitorId): Response
    {
        $response = $this->shinobi->getHttpClient()->get("{$this->shinobi->getToken()}/mp4/{$this->shinobi->getGroupKey()}/{$monitorId}/s.mp4");
        return $response->throw();
    }
}
