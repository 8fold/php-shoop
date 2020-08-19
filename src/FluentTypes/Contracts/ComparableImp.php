<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Closure;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;

use Eightfold\Shoop\PipeFilters\IsGreaterThan;
use Eightfold\Shoop\PipeFilters\IsGreaterThanOrEqualTo;

use Eightfold\Shoop\PipeFilters\IsLessThan;
use Eightfold\Shoop\PipeFilters\IsLessThanOrEqualTo;

/**
 * TODO: Make extension of Shooped
 */
trait ComparableImp
{
    public function is($compare): ESBoolean
    {
        return Is::applyWith($compare)->unfoldUsing($compare);
    }

    public function isNot($compare): ESBoolean
    {
        return $this->is($compare)->toggle();
    }

    public function isEmpty(): ESBoolean
    {
        $bool = IsEmpty::apply()->unfoldUsing($this);
        return ESBoolean::fold($bool);
    }

    public function isNotEmpty(): ESBoolean
    {
        $bool = $this->isEmpty()->toggle();
        return ESBoolean::fold($bool);
    }

    public function isGreaterThan($compare): ESBoolean
    {
        $bool = $this->unfold() > $compare->unfold();
        return ESBoolean::fold($bool);
    }

    /**
     * @deprecated
     */
    public function isGreaterThanOrEqual($compare): ESBoolean
    {
        return $this->isGreaterThanOrEqualTo($compare, $closure);
    }

    public function isGreaterThanOrEqualTo($compare): ESBoolean
    {
        $bool = $this->unfold() >= $compare->unfold();
        return ESBoolean::fold($bool);
    }

    public function isLessThan($compare): ESBoolean
    {
        $bool = $this->unfold() < $compare->unfold();
        return ESBoolean::fold($bool);
    }

    /**
     * @deprecated
     */
    public function isLessThanOrEqual($compare): ESBoolean
    {
        return $this->isLessThanOrEqualTo($compare, $closure);
    }

    public function isLessThanOrEqualTo($compare): ESBoolean
    {
        $bool = $this->unfold() <= $compare->unfold();
        return ESBoolean::fold($bool);
    }

    public function countIsGreaterThan($compare): ESBoolean
    {
        return $this->countIs($compare, IsGreaterThan::class);
    }

    public function countIsGreaterThanOrEqualTo($compare): ESBoolean
    {
        return $this->countIs($compare, IsGreaterThanOrEqualTo::class);
    }

    public function countIsLessThan($compare): ESBoolean
    {
        return $this->countIs($compare, IsLessThan::class);
    }

    public function countIsLessThanOrEqualTo($compare): ESBoolean
    {
        return $this->countIs($compare, IsLessThanOrEqualTo::class);
    }

    private function countIs($compare, string $functionName): ESBoolean
    {
        if (is_a($compare, Foldable::class)) {
            $compare = $compare->unfold();
        }

        $bool = Shoop::pipe($this->count(),
            $functionName::applyWith(
                AsInteger::apply()->unfoldUsing($compare)
            )
        )->unfold();

        return ESBoolean::fold($bool);
    }
}
