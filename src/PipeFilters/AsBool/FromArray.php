<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBool;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsInt;
use Eightfold\Shoop\PipeFilters\IsNot;

use Eightfold\Shoop\Php\StringIsJson;

class FromArray extends Filter
{
    public function __invoke(array $payload): bool
    {
        return Shoop::pipe($payload,
            AsInt::apply(),
            IsNot::apply()
        )->unfold();
    }
}
