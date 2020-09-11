<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class Type extends Filter
{
    static public function __callStatic(string $name, array $arguments)
    {
        $className = __NAMESPACE__ ."\\TypeFilters\\". ucfirst($name); // TODO: First -> UpperCase
        $count = Count::fromList($arguments);
        return (Is::fromNumber($count, 0))
            ? $className::apply()
            : $className::applyWith(...$arguments);
    }
}
