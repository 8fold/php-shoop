<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

class AllPass extends Filter
{
    private $predicate;

    public function __construct(callable $predicate)
    {
        $this->predicate = $predicate;
    }

    public function __invoke(iterable $using): bool
    {
        $predicate = $this->predicate;
        foreach ($using as $value) {
            if (! $predicate($value)) {
                return false;
            }
        }
        return true;
    }
}
