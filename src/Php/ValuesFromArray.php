<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ValuesFromArray extends Bend
{
    public function __invoke(array $payload): array
    {
        return array_values($payload);
    }
}
