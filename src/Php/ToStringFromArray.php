<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php\ToStringFromArrayGlue;

class ToStringFromArray
{
    public function __invoke(array $payload): string
    {
        // TODO: Test directly
        return implode($payload["array"], $payload["glue"]);
    }
}
