<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class ArrayFromBoolean extends Filter
{
    public function __invoke(bool $payload): array
    {
        return [$payload];
    }
}
