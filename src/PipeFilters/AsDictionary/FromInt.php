<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsDictionary;

class FromInt extends Filter
{
    public function __invoke(int $using): array
    {
        return Shoop::pipe($using,
            AsArray::applyWith(...$this->args(true)),
            AsDictionary::apply()
        )->unfold();

    }
}
