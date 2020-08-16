<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsJson;

class IsString extends Filter
{
    /**
     * String must be PHP string type and not a more specific type of string.
     *
     * Only JSON account for.
     */
    public function __invoke($using): bool
    {
        if (! is_string($using)) return false;

        if (is_string($using) and IsJson::apply()->unfoldUsing($using)) return false;

        return true;
    }
}
