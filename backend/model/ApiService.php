<?php

namespace backend\model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiService
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.github.com/',
            'timeout' => 5.0,
        ]);

        $config = include __DIR__ . '/../../config.php';
        $this->apiKey = $config['github_api_token'] ?? '';
    }

    public function fetchData(): ?array
    {
        try {
            $response = $this->client->request('GET', 'users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (GuzzleException $exception) {
            echo 'Error API: ' . $exception->getMessage();
        }
        return null;
    }
}
