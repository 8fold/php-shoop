<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use \Closure;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;

use Eightfold\Shoop\PipeFilters\Is;
use Eightfold\Shoop\PipeFilters\IsEmpty;
use Eightfold\Shoop\PipeFilters\IsGreaterThan;
use Eightfold\Shoop\PipeFilters\IsGreaterThanOrEqualTo;

use Eightfold\Shoop\FluentTypes\ESBoolean;

/**
 * TODO: Make extension of Shooped
 */
trait ComparableImp
{
    public function is($compare): ESBoolean
    {
        return ESBoolean::fold(
            Is::applyWith($compare)->unfoldUsing($this->main)
        );
    }

    public function isNot($compare): ESBoolean
    {
        return ESBoolean::fold(
            $this->is($compare)->toggle()
        );
    }

    public function isEmpty(): ESBoolean
    {
        return ESBoolean::fold(
            IsEmpty::apply()->unfoldUsing($this->unfold())
        );
    }

    public function isNotEmpty(): ESBoolean
    {
        return $this->isEmpty()->toggle();
    }

    public function isGreaterThan($compare): ESBoolean
    {
        return ESBoolean::fold(
            IsGreaterThan::applyWith($compare)->unfoldUsing($this->unfold())
        );
    }

    public function isGreaterThanOrEqualTo($compare): ESBoolean
    {
        return ESBoolean::fold(
            IsGreaterThanOrEqualTo::applyWith($compare)
                ->unfoldUsing($this->unfold())
        );
    }

    public function isLessThan($compare): ESBoolean
    {
        return $this->isGreaterThanOrEqualTo($compare)->reverse();
    }

    public function isLessThanOrEqualTo($compare): ESBoolean
    {
        return $this->isGreaterThan($compare)->reverse();
    }
}
