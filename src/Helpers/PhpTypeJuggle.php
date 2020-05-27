<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\{
    PhpIndexedArray,
    PhpBool,
    PhpAssociativeArray,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESArray,
    ESDictionary,
    ESObject,
    ESJson
};

class PhpTypeJuggle
{
    static public function arrayToInt(array $array = []): int
    {
        return count($array);
    }

    static public function arrayToString(array $array = []): string
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
