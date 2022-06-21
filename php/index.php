<?php

require __DIR__ . "/vendor/autoload.php";

use Source\Services\Backend;
use Source\Services\QuotesApi;
use Source\Services\CharactersApi;

function findCharacterByName() { }

function createCharacter($name, $imageUrl) { }

function insertQuote($id, $quote) { }

function insertQuotes($id, $quotes) { }

function getQuotes($name) { }

function deleteData() { echo 'delete'; }

function show() { echo 'list'; }

function main() {
  $val = getopt("n:");

  if(empty($val)){
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
      $teste = new Backend;
      echo $teste->teste();

      break;
  }
}

main();