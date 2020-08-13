<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class MembersFromArray extends Filter
{
    public function __invoke(array $payload): array
    {
        return array_keys($payload);
    }
}
