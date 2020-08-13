<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ReverseBool extends Bend
{
    public function __invoke(bool $payload): bool
    {
        return ! $payload;
    }
}
