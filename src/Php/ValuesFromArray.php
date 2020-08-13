<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class ValuesFromArray extends Filter
{
    public function __invoke(array $payload): array
    {
        return array_values($payload);
    }
}
