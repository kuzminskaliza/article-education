<?php

namespace backend\model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GitHubApiClient
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $config = include __DIR__ . '/../config-local.php';

        $this->apiKey = $config['github_api_token'] ?? '';
        $baseUri = $config['github_api_url'] ?? '';
        $timeout = $config['timeout'];

        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
        ]);
    }

    public function fetchData(): ?array
    {
        try {
            $response = $this->client->request('GET', 'users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-type' => 'application/json',
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
