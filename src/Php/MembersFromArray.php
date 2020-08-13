<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class MembersFromArray extends Bend
{
    public function __invoke(array $payload): array
    {
        return array_keys($payload);
    }
}
