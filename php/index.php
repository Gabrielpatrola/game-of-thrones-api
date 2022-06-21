<?php

require __DIR__ . "/vendor/autoload.php";

use Source\Main;

$main = new Main();

try {
    $main->main();
} catch (Exception $e) {
    echo $e;
}
