<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToArrayFromObject extends Bend
{
    public function __invoke(object $payload): array
    {
        return (array) $payload;
    }
}
