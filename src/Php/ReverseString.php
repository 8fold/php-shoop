<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

class ReverseString
{
    public function __invoke(string $payload): string
    {
        $array = Php::stringToArray($payload);
        $array = Php::arrayReversed($array);
        return Php::arrayToString($array, "");
    }
}
