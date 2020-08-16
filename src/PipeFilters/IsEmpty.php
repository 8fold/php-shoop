<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Shoop\PipeFilters\IsEmpty\FromArray;
use Eightfold\Shoop\PipeFilters\IsEmpty\FromBool;
use Eightfold\Shoop\PipeFilters\IsEmpty\FromDictionary;
use Eightfold\Shoop\PipeFilters\IsEmpty\FromInt;
use Eightfold\Shoop\PipeFilters\IsEmpty\FromJson;
use Eightfold\Shoop\PipeFilters\IsEmpty\FromObject;

class IsEmpty extends Filter
{
    public function __invoke($using): bool
    {
        return ! AsBoolean::apply()->unfoldUsing($using);
    }
}
