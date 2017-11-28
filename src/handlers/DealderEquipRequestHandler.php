<?php

namespace handlers;

use GuzzleHttp\Client;
use VDB\Spider\Resource;
use VDB\Spider\Uri\DiscoveredUri;
use VDB\Spider\Spider;
use VDB\Spider\RequestHandler\RequestHandlerInterface;

class DealderEquipRequestHandler implements RequestHandlerInterface
{
    private $client;

    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client();
        }
        return $this->client;
    }

    public function request(DiscoveredUri $uri)
    {
//        echo $uri->toString();
        $response = $this->getClient()->get($uri->toString(), ['headers' => ['Cookie' => 'PAGE_SIZE=9;']]);
        return new Resource($uri, $response);
    }
}