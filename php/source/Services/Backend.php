<?php

namespace Source\Services;

use Exception;

class Backend
{
    private string $apiUrl;
    private array $headers;

    private array $params;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://backend-challenge.hasura.app/v1/graphql';

        $this->headers = [
            'Content-Type: application/json',
            'x-hasura-admin-secret: uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
        ];
    }

    /**
     * Function that handles character store in external API and returns an ID
     * @return string | Exception
     * @throws Exception
     */
    public function store($name, $imageUrl)
    {
        $this->params = [
            'query' => "mutation CreateCharacter {\n  insert_Character(objects: {name: \"{$name}\", image_url: \"{$imageUrl}\"}) {\n    returning {\n      id\n    }\n  }\n}",
            'operationName' => 'CreateCharacter'
        ];

        $this->post();

        $payload = $this->callback;

        if (!property_exists($payload, 'data')) throw new Exception($this->callback->errors[0]->message);

        return $payload->data->insert_Character->returning[0]->id;
    }

    /**
     * Function that handles a character quote store in external API and returns a response object
     * @return object | Exception
     * @throws Exception
     */
    public function storeQuote($id, $quote)
    {
        $sanitazeQuote = str_replace('"', '', $quote);

        $this->params = [
            'query' => "mutation CreateQuote {\n  insert_Quote(objects: {text: \"{$sanitazeQuote}\", character_id: \"{$id}\"}) {\n    returning {\n      id\n      text\n    }\n  }\n}\n",
            'operationName' => 'CreateQuote'
        ];

        $this->post();

        $payload = $this->callback;

        if (!property_exists($payload, 'data')) throw new Exception($this->callback->errors[0]->message);

        return $payload->data->insert_Quote->returning;
    }

    /**
     * Function that return all information in external API
     * @return object | Exception
     * @throws Exception
     */
    public function getAll()
    {
        $this->params = [
            'query' => "{\n  Character {\n    Quotes {\n      text\n      id\n    }\n    id\n    image_url\n    name\n  }\n}\n",
        ];

        $this->post();

        $payload = $this->callback;

        if (!property_exists($payload, 'data')) throw new Exception($this->callback->errors[0]->message);

        return $payload->data->Character;
    }

    /**
     * Function that delete everything in external API
     * @return object | Exception
     * @throws Exception
     */
    public function destroy()
    {
        $this->params = [
            'query' => "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n",
            'operationName' => 'DeleteAll'
        ];

        $this->post();

        $payload = $this->callback;

        if (!property_exists($payload, 'data')) throw new Exception($this->callback->errors[0]->message);

        return $payload->data->delete_Character;
    }

    private function post()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($this->params),
            CURLOPT_HTTPHEADER => $this->headers,
        ]);

        $this->callback = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}
