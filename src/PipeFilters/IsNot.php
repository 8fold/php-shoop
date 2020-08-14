<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsNot extends Filter
{
    public function __invoke($using): bool
    {
        return $using !== Shoop::pipe($this->args, PullFirst::apply())->unfold();
    }
}
