<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Shoop;

class IsObject extends Filter
{
    /**
     * An object, is a PHP object, that is not an instance of `stdClass` and
     * implements at least one public method.
     */
    public function __invoke($using): bool
    {
        return (is_object($using) and ! is_a($using, stdClass::class))
            ? true
            : false;
    }
}
