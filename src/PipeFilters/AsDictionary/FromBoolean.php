<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

class FromBoolean extends Filter
{
    public function __invoke(bool $using): array
    {
        return ($using === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }
}
