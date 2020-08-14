<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

class FromObject extends Filter
{
    public function __invoke(object $using): array
    {
        return (array) $using;
    }
}
