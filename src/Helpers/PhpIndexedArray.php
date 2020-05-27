<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\PhpTypeJuggle;

class PhpIndexedArray
{
    static public function toBool(array $array = []): bool
    {
        return self::toInt($array) > 0;
    }

    static public function toAssociativeArray(array $array = []): array
    {
        $build = [];
        foreach ($array as $member => $value) {
            $member = "i". $member;
            $build[$member] = $value;
        }
        return $build;
    }

    static public function toInt(array $array = []): int
    {
        return count($array);
    }

    static public function toJson(array $array = []): string
    {
        $object = self::toObject($array);
        $json = json_encode($object);
        return $json;
    }

    static public function toObject(array $array = []): object
    {
        $associativeArray = self::toAssociativeArray($array);
        $object = (object) $associativeArray;
        return $object;
    }

    static public function toString(array $array = []): string
    {
        $printed = print_r($array, true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return trim($fixSpacingWhenEmpty);
    }
}
