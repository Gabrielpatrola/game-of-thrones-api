<?php

namespace Source\Services;

use Exception;

class QuotesApi
{
    private string $apiUrl;
    private array $headers;

    private string $endPoint;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://api.gameofthronesquotes.xyz/v1/';

        $this->headers = [
            'Content-Type: application/json',
            'accept: application/json',
        ];
    }

    /**
     * Funciton that get all quotes from an especific character from external API
     * @throws Exception
     */
    public function getAll($name)
    {
        $normalizedName = strtolower($name);
        $this->endPoint = "character/{$normalizedName}";
        $this->get();

        $payload = $this->callback;

        if(empty($payload)) throw new Exception('No data');

        return $payload[0]->quotes;
    }

    private function get()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . $this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $this->headers,
        ]);

        $this->callback = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}
