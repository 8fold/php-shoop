<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsString;

use Eightfold\Foldable\Filter;

class FromBool extends Filter
{
    public function __invoke(bool $using): string
    {
        return ($using) ? "true" : "false";
    }
}
