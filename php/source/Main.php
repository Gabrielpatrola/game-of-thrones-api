<?php

namespace Source;

use Exception;
use Source\Services\Backend;
use Source\Services\QuotesApi;
use Source\Services\CharactersApi;
use Source\Helpers\Util;

use stdClass;

class Main
{
    private QuotesApi $quotesApi;
    private CharactersApi $charactersApi;
    private Backend $backend;
    private Util $util;

    public function __construct()
    {
        $this->backend = new Backend;
        $this->charactersApi = new CharactersApi;
        $this->quotesApi = new QuotesApi;
        $this->util = new Util;
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
     * @return bool|array
     * @throws Exception
     */
    private function findCharacters(): bool|array
    {
        $characters = $this->charactersApi->getAll();

        if (!$characters) {
            throw new Exception('No data!');
        }

        return $characters;
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
     * @param $name
     * @throws Exception
     */
    private function insertQuotes($id, $quotes, $name): void
    {
        foreach ($quotes as $key => $quote) {
            echo "sleeping 5 seconds because of api rate limit\r\n";
            sleep(5);
            $this->backend->storeQuote($id, $quote);
            echo "quote #$key for $name inserted in database\r\n";
        }
        echo "All quotes for $name inserted in database\r\n";
    }

    /**
     * @param $name
     * @return Exception|array'
     * @throws Exception
     */
    private function getQuotesByName($name): Exception|array
    {
        return $this->quotesApi->getAllQuotesByName($name);
    }

    /**
     * @return Exception|array
     * @throws Exception
     */
    private function getAllQuotesAndInfo(): Exception|array
    {
        return $this->quotesApi->getAllQuotesAndInfo();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function deleteData(): void
    {
        $response = $this->backend->destroy();
        print_r($response);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function show(): void
    {
        $response = $this->backend->getAll();
        print_r($response);
    }

    /**
     * Method that handle mass character insert in database
     * @throws Exception
     */
    private function massInsert(): void
    {
        $characters = $this->findCharacters();
        $allCharactersQuotesAndInfo = $this->getAllQuotesAndInfo();

        $normalizedCharacters = $this->util->removeDuplicate($characters, 'fullName');

        foreach ($normalizedCharacters as $character) {
            $nameArray = explode(' ', $character->fullName);
            $nomarlizedName = strtolower($nameArray[0]);

            $characterQuotes = [];
            foreach ($allCharactersQuotesAndInfo as $characterQuotesAndInfo) {
                if (str_contains($characterQuotesAndInfo->slug, $nomarlizedName)) {
                    $characterQuotes = $characterQuotesAndInfo->quotes;
                }
            }

            $newCharacterId = $this->createCharacter($character->fullName, $character->imageUrl);
            echo "Character $character->fullName inserted in database\r\n";

            if (!empty($characterQuotes)) {
                $this->insertQuotes($newCharacterId, $characterQuotes, $character->fullName);
            }
        }
        echo "Mass inserted done with success!\r\n";
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
            throw new Exception('Please provide a character name or a command like: list, delete');
        }

        try {
            switch ($val['n']) {
                case "delete":
                    $this->deleteData();
                    break;
                case "list":
                    $this->show();
                    break;
                case "mass":
                    $this->massInsert();
                    break;
                default:
                    $character = $this->findCharacterByName($val['n']);
                    $newCharacterId = $this->createCharacter($character->fullName, $character->imageUrl);
                    $quotes = $this->getQuotesByName($character->firstName);

                    if (!empty($quotes)) {
                        $this->insertQuotes($newCharacterId, $quotes, $character->fullNam);
                    }
                    echo 'Character inserted in database';
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
