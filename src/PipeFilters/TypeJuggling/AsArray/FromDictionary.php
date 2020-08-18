<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;

use Eightfold\Foldable\Filter;

/**
 * @deprecated in favor of FromList
 */
class FromDictionary extends Filter
{
    public function __invoke(array $using): array
    {
        return array_values($using);
    }
}
