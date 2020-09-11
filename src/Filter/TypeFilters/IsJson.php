<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsJson extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_string($using)) {
            return false;
        }

        if (strlen($using) < 2) {
            return false;

        } elseif ($using[0] !== "{") {
            return false;

        } elseif ($using[strlen($using) - 1] !== "}") {
            return false;

        } elseif (! is_object(json_decode($using))) {
            return false;

        }

        return json_last_error() === JSON_ERROR_NONE;
    }
}
