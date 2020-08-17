<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

class IsEmpty extends Filter
{
    public function __invoke($using): bool
    {

        if (is_string($using)) {
            $length = strlen($using);
            if ($length >= 2 and
                $using[0] === "{" and
                $using[$length -1] === "}"
            ) {
                return $using === "{}";

            }
            return empty($using);
        }

        if (! is_object($using)) return empty($using);

        $properties = get_object_vars($using);
        if (is_a($using, stdClass::class)) {
            return count($properties) > 0;

        }

        $methods = get_class_methods($using);
        $merged  = array_merge($properties, $methods);

        return count($merged) === 0;
    }
}
