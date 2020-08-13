<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class ToIntegerFromString extends Filter
{
    public function __invoke(string $payload): int
    {
        return strlen($payload);
    }
}
