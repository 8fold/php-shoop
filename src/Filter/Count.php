<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class Count extends Filter
{
    public function __invoke(string $using): bool
    {
    }

    static public function fromList(array $using): int
    {
        return count($using);
    }
}
