<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use Eightfold\Foldable\Apply as BaseApply;

use Eightfold\Shoop\Filter\StartsWith;

class Apply extends BaseApply
{
    static public function classNameForFilter($filterName)
    {
        $filterName = ucfirst($filterName);
        $namespace = __NAMESPACE__ ."\\Filter\\";
        if (StartsWith::fromString($filterName, "Is")) {
            $namespace = $namespace ."Is\\";

        } elseif (StartsWith::fromString($filterName, "As")) {
            $namespace = $namespace ."TypeJuggling\\";

        }
        return $namespace . $filterName;
    }
}
