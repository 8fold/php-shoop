<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

// TODO: Increase type-safety by using established type-check pattern
class Is extends Filter
{
    private $compare = "";

    public function __construct($compare = "")
    {
        $this->compare = $compare;
    }

    public function __invoke($using): bool
    {
        return $using === $this->compare;
    }
}
