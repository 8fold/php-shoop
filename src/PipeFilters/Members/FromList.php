<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Members;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromList as AsArrayFromList;

class FromList extends Filter
{
    public function __invoke(array $using): array
    {
        return array_keys($using);
    }
}
