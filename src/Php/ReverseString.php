<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\ToArrayFromString;
use Eightfold\Shoop\Php\ReverseArray;
use Eightfold\Shoop\Php\ToStringFromArray;

use Eightfold\Shoop\Php;

class ReverseString extends Bend
{
    public function __invoke(string $payload): string
    {
        return Shoop::pipeline($payload,
            ToArrayFromString::bend(),
            ReverseArray::bend(),
            ToStringFromArray::bend()
        )->unfold();
    }
}
