<?php

namespace App\Wrappers;

use GuzzleHttp\Client;

class ApiWrapper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://newsapi.org/v2', // API base URI
        ]);
    }

    public function getData()
    {
        $endpoint = 'https://newsapi.org/v2/top-headlines'; // API endpoint
        $apiKey = env('API_KEY'); // Access the API key from the .env file
        $response = $this->client->request('GET', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey, // Use the API key in the request
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    
}
