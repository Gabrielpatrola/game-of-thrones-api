<?php

namespace Source;

use Exception;
use Source\Services\Backend;
use Source\Services\QuotesApi;
use Source\Services\CharactersApi;
use stdClass;

class Main
{
    private QuotesApi $quotesApi;
    private CharactersApi $charactersApi;
    private Backend $backend;

    public function __construct()
    {
        $this->backend = new Backend;
        $this->charactersApi = new CharactersApi;
        $this->quotesApi = new QuotesApi;
    }


    /**
     * @param $name
     * @return bool|stdClass
     * @throws Exception
     */
    private function findCharacterByName($name): bool|stdClass
    {
        $characters = $this->charactersApi->getAll();
        $foundCharacter = false;

        foreach ($characters as $character) {
            if ($character->firstName === $name) {
                $foundCharacter = $character;
            }
        }

        if (!$foundCharacter) {
            throw new Exception('Name not found in characters api! Try other name');
        }

        return $foundCharacter;
    }

    /**
     * @param $name
     * @param $imageUrl
     * @return Exception|string
     * @throws Exception
     */
    private function createCharacter($name, $imageUrl): Exception|string
    {
        return $this->backend->store($name, $imageUrl);
    }

    /**
     * @param $id
     * @param $quotes
     * @return void
     * @throws Exception
     */
    private function insertQuotes($id, $quotes): void
    {
        foreach ($quotes as $quote) {
            $this->backend->storeQuote($id, $quote);
        }
    }

    /**
     * @param $name
     * @return Exception|array
     * @throws Exception
     */
    private function getQuotes($name): Exception|array
    {
        return $this->quotesApi->getAll($name);
    }

    /**
     * @return Exception|bool|string
     * @throws Exception
     */
    private function deleteData(): Exception|bool|string
    {

        try {
            $response = $this->backend->destroy();
            return print_r($response);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return Exception|bool|string
     * @throws Exception
     */
    private function show(): Exception|bool|string
    {
        try {
            $response = $this->backend->getAll();
            return print_r($response);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Main function that handles the execution logic based on user's input
     * @return void
     * @throws Exception
     */
    public function main(): void
    {
        $val = getopt("n:");

        if (empty($val)) {
            var_dump($val);
            throw new Exception('Please provide a character name or a command like: list, delete');
        }

        switch ($val['n']) {
            case "delete":
                $this->deleteData();
                break;
            case "list":
                $this->show();
                break;
            default:
                $character = $this->findCharacterByName($val['n']);
                $newCharacterId = $this->createCharacter($character->fullName, $character->imageUrl);
                $quotes = $this->getQuotes($character->firstName);

                if (!empty($quotes)) {
                    $this->insertQuotes($newCharacterId, $quotes);
                }
                echo 'Character inserted in database';
                break;
        }
    }
}
