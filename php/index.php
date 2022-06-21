<?php

require __DIR__ . "/vendor/autoload.php";

use Source\Services\Backend;
use Source\Services\QuotesApi;
use Source\Services\CharactersApi;

/**
 * @param $name
 * @return bool|stdClass
 * @throws Exception
 */
function findCharacterByName($name): bool|stdClass
{
    $charactersApi = new CharactersApi;
    $characters = $charactersApi->getAll();
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
function createCharacter($name, $imageUrl): Exception|string
{
    $backend = new Backend;
    return $backend->store($name, $imageUrl);
}

/**
 * @param $id
 * @param $quotes
 * @return void
 * @throws Exception
 */
function insertQuotes($id, $quotes): void
{
    $backend = new Backend;

    foreach ($quotes as $quote) {
        $backend->storeQuote($id, $quote);
    }
}

/**
 * @param $name
 * @return Exception|array
 * @throws Exception
 */
function getQuotes($name): Exception|array
{
    $quotesApi = new QuotesApi;
    return $quotesApi->getAll($name);
}

/**
 * @return Exception|bool|string
 * @throws Exception
 */
function deleteData(): Exception|bool|string
{
    $backend = new Backend;

    try {
        $response = $backend->destroy();
        return print_r($response);
    } catch (Exception $e) {
        return $e;
    }
}

/**
 * @return Exception|bool|string
 * @throws Exception
 */
function show(): Exception|bool|string
{
    $backend = new Backend;

    try {
        $response = $backend->getAll();
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
function main()
{
    $val = getopt("n:");

    if (empty($val)) {
        var_dump($val);
        throw new Exception('Please provide a character name or a command like: list, delete');
    }

    switch ($val['n']) {
        case "delete":
            deleteData();
            break;
        case "list":
            show();
            break;
        default:
            $character = findCharacterByName($val['n']);
            $newCharacterId = createCharacter($character->fullName, $character->imageUrl);
            $quotes = getQuotes($character->firstName);

            if (!empty($quotes)) {
                insertQuotes($newCharacterId, $quotes);
            }

            echo 'Character inserted in database';
            break;
    }
}

try {
    main();
} catch (Exception $e) {
    echo $e;
}
