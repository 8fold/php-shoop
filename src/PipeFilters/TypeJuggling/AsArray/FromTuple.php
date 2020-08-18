<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;

use Eightfold\Foldable\Filter;

/**
 * @deprecated in favor of FromList
 */
class FromTuple extends Filter
{
    public function __invoke(object $using): array
    {
        if (IsTuple::apply()->unfoldUsing($using)) {
            return (array) $using;
        }
        return AsArray::apply()->unfoldUsing($using);
    }
}
