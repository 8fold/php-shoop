<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ArrayFromBoolean extends Bend
{
    public function __invoke(bool $payload): array
    {
        return [$payload];
    }
}
