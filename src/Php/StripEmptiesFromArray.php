<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StripArray;
use Eightfold\Shoop\Php\ValuesFromArray;

class StripEmptiesFromArray extends Bend
{
    public function __invoke(array $payload): array
    {
        return Shoop::pipeline($payload,
            StripArray::bend(),
            ValuesFromArray::bend()
        )->unfold();
    }
}
