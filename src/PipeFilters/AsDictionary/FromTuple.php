<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

use \stdClass;

class FromTuple extends Filter
{
    public function __invoke(stdClass $using): array
    {
        return (array) $using;
    }
}
