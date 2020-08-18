<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple;

use Eightfold\Foldable\Filter;

use \Closure;

class FromObject extends Filter
{
    /**
     * TODO: What types are considered PHP objects - is it just class and stdClass?
     */
    public function __invoke(object $using): object
    {
        $properties = get_object_vars($using);

        $filtered = array_filter($properties,
            function($v, $k) {
                return $v !== null and ! is_a($v, Closure::class);
            },
            ARRAY_FILTER_USE_BOTH
        );
        $tuple = (object) $filtered;
        return $tuple;
    }
}