<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use Eightfold\Foldable\Apply as BaseApply;

use Eightfold\Shoop\Filter\Append;
use Eightfold\Shoop\Filter\StartsWith;

class Apply extends BaseApply
{
    static public function classNameForFilter($filterName)
    {
        $filterName = ucfirst($filterName);
        $namespace = Append::fromString(__NAMESPACE__, "\\Filter\\");
        if (StartsWith::fromString($filterName, "Is")) {
            $namespace = Append::fromString($namespace, "Is\\");

        } elseif (StartsWith::fromString($filterName, "As")) {
            $namespace = Append::fromString($namespace, "TypeJuggling\\");

        }
        return Append::fromString($namespace, $filterName);
    }
}
