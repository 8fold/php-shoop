<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToArrayFromString extends Bend
{
    public function __invoke(string $payload): array
    {
        return preg_split('//u', $payload, -1, PREG_SPLIT_NO_EMPTY);
    }
}
