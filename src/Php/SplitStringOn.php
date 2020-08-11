<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

class SplitStringOn
{
    public function __invoke(array $payload): array
    {
        $string         = $payload["string"];
        $splitter       = $payload["splitter"];
        $includeEmpties = $payload["includeEmpties"];
        $limit          = $payload["limit"];

        $array = explode($splitter, $string, $limit);
        return ($includeEmpties)
            ? $array
            : Php::arrayWithoutEmpties($array);
            // $array = array_filter($array);
            // $array = array_values($array);
    }
}
