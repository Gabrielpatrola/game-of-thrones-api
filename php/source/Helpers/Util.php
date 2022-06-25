<?php

namespace Source\Helpers;

class Util
{
    /**
     * Function that remove duplicated entries from array
     * @param $array
     * @param $key
     * @return array
     */
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
