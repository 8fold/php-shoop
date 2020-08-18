<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Minus;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromList as AsArrayFromList;

class FromList extends Filter
{
    public function __invoke(array $using): array
    {
        $using = array_diff($using, $this->args(true));
        return AsArrayFromList::apply()->unfoldUsing($using);
    }
}
