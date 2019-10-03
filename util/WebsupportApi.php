<?php
declare(strict_types = 1);

namespace util;

use core\HttpClient;
use core\HttpResponse;

class WebsupportApi
{
    private const API_URL = 'https://rest.websupport.sk/v1/user/self/';
    private $client;

    public function __construct(HttpClient $curl)
    {
        $this->client = $curl;
        $this->client->auth(WP_API_USER, WP_API_PASSWORD);
    }

    public function getZones(): HttpResponse
    {
        $url = self::API_URL . 'zone';

        return $this->client->get($url);
    }

    public function getZone(string $name): HttpResponse
    {
        $url = self::API_URL . 'zone/' . $name;

        return $this->client->get($url);
    }

    public function getRecords(string $name): HttpResponse
    {
        $url = self::API_URL . 'zone/' . $name . '/record';

        return $this->client->get($url);
    }

    public function createRecord(string $name, array $data): HttpResponse
    {
        $url = self::API_URL . 'zone/' . $name . '/record';
        $data = json_encode($data);

        return $this->client->post($url, [
           'data' => $data,
           'headers' => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
           ]
        ]);
    }

    public function deleteRecord(string $name, string $id): HttpResponse
    {
        $url = self::API_URL . 'zone/' . $name . '/record/' . $id;

        return $this->client->delete($url);
    }
}
