<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php\ToStringFromArrayGlue;

class ToStringFromArray
{
    public function __invoke(array $payload): string
    {
        // TODO: Test directly
        $strings = array_filter($payload["array"], "is_string");
        return implode($strings, $payload["glue"]);
    }
}
