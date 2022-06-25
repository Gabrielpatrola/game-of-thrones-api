<?php

namespace Source\Helpers;

class Util
{
    function removeDuplicate($array, $key): array
    {
        $result = [];
        foreach ($array as $i) {
            if (!isset($result[$i->{$key}])) {
                $result[$i->{$key}] = $i;
            }
        }
        return $result;
    }
}
