<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Type;

class AsRange extends Filter
{
    public function __invoke($using): array
    {
        if (Type::isBoolean()->unfoldUsing($using)) {
            return static::fromBoolean($using);

        } elseif (Type::isNumber()->unfoldUsing($using)) {
            return static::fromNumber($using);

        } elseif (Type::isString()->unfoldUsing($using)) {
            return static::fromString($using);

        } elseif (Type::isList()->unfoldUsing($using)) {
            return static::fromList($using);

        } elseif (Type::isTuple()->unfoldUsing($using)) {
            return static::fromTuple($using);

        } elseif (Type::isObject()->unfoldUsing($using)) {
            return static::fromObject($using);

        }
    }

    // TODO: PHP 8.0 - int|float, int|float
    static public function fromNumber($start, $end): array
    {
        return range($start, $end);
    }
}
