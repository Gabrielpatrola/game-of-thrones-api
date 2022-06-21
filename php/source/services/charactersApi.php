<?php

namespace Source\Services;

use Exception;

class CharactersApi
{
    private string $apiUrl;
    private array $headers;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://thronesapi.com/api/v2/Characters';

        $this->headers = [
            'Content-Type: application/json',
            'accept: application/json',
        ];
    }

    /**
     * Function that return all available characters from external API
     * @throws Exception
     */
    public function getAll()
    {
        $this->get();

        $payload = $this->callback;

        if(empty($payload)) throw new Exception('No data');

        return $payload;
    }

    private function get()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
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
