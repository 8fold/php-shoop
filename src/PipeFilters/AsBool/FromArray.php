<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBool;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\IsNot;

use Eightfold\Shoop\Php\StringIsJson;

class FromArray extends Filter
{
    public function __invoke(array $using): bool
    {
        return Shoop::pipe($using,
            AsInteger::apply(),
            IsNot::applyWith(0)
        )->unfold();
    }
}
