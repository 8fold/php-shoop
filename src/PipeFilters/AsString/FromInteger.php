<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsString;

use Eightfold\Foldable\Filter;

class FromInteger extends Filter
{
    public function __invoke(int $using): string
    {
        return strval($using);
    }
}
