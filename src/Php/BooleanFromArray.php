<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class BooleanFromArray extends Bend
{
    public function __invoke(array $payload): bool
    {
        return Shoop::pipeline($payload,
            ToIntegerFromArray::bend(),
            IntegerIsGreaterThan::bendWith(0)
        )->unfold();
    }
}
