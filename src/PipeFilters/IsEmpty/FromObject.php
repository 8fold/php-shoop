<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\IsEmpty;

class FromObject extends Filter
{
    public function __invoke(object $using): bool
    {
        $properties = get_object_vars($using);
        $methods = get_class_methods($using);
        $using = array_merge($properties, $methods);
        return Shoop::pipe($using, AsArray::apply(), IsEmpty::apply())->unfold();
    }
}
