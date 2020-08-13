<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToDictionaryFromObject extends Bend
{
    public function __invoke(object $payload): array
    {
        return (array) $payload;
    }
}
