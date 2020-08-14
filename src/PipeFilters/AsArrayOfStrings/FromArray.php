<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsArrayOfStrings;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\DropEmpties;

class FromArray extends Filter
{
    public function __invoke(array $using): array
    {
        return Shoop::pipe($using, DropEmpties::applyWith("is_string"))
            ->unfold();
    }
}
