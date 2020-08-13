<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class BooleanFromArray extends Filter
{
    public function __invoke(array $payload): bool
    {
        return Shoop::pipe($payload,
            ToIntegerFromArray::apply(),
            IntegerIsGreaterThan::applyWith(0)
        )->unfold();
    }
}
