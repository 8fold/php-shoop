<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

class TagsStrippedFromString
{
    public function __invoke(array $payload): string
    {
        $string = $payload["string"];
        $allow  = implode("", $payload["allowed"]);
        return strip_tags($string, $allow);
    }
}
