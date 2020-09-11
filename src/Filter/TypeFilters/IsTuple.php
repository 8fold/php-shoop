<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

class Istuple extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_object($using) and ! is_string($using)) {
            return false;
        }

        if (is_a($using, stdClass::class)) {
            return true;
        }

        if (is_object($using) and
            empty(get_class_methods($using)) and
            ! empty(get_object_vars($using))
        ) {
            return true;
        }

        return IsJson::apply()->unfoldUsing($using);
    }
}
