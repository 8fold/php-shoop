<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToIntegerFromArray extends Bend
{
    public function __invoke(array $payload): int
    {
        return count($payload);
    }
}
