<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\Equatable;

class ESRange implements \Iterator, \Countable, Equatable
{
    private $min;

    private $max;

    private $rangeAsValues = [];

    static public function init(int $min = 0, int $max = 0, bool $includeLast = true)
    {
        return new ESRange(
            ESInt::init($min),
            ESInt::init($max),
            ESBool::init($includeLast)
        );
    }

    public function __construct(ESInt $min, ESInt $max, ESBool $includeLast)
    {
        if ($min->isGreaterThan($max)->bool()) {
            $this->min = ESInt::init(0);
            $this->max = ESInt::init(0);

        } else {
            $this->min = $min;
            $this->max = ($includeLast->bool()) ? $max : $max->minus(ESInt::init(1));
        }

        $this->rangeAsValues = range($this->min->int(), $this->max->int());
    }

    public function min(): ESInt
    {
        return $this->min;
    }

    public function max(): ESInt
    {
        return $this->max;
    }

//-> Iterator
    public function current(): ESInt
    {
        $current = key($this->rangeAsValues);
        return ESInt::init($this->rangeAsValues[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::init(key($this->rangeAsValues));
    }

    public function next(): ESRange
    {
        next($this->rangeAsValues);
        return $this;
    }

    public function rewind(): ESRange
    {
        reset($this->rangeAsValues);
        return $this;
    }

    public function valid(): bool
    {
        $key = key($this->rangeAsValues);
        $var = ($key !== null && $key !== false);
        return $var;
    }

//-> Accessing elements
    public function first(): ESInt
    {
        $first = array_shift($this->rangeAsValues);
        return ESInt::init($first);
    }

    public function last(): ESInt
    {
        $last = array_pop($this->rangeAsValues);
        return ESInt::init($last);
    }

//-> Inspection
    public function isEmpty(): ESBool
    {
        if ($this->max()
            ->minus($this->min())
            ->isGreaterThan(ESInt::init(0), true)
            ->bool()
        ) {
            return ESBool::init(false);
        }
        return ESBool::init(true);
    }

    public function count(): ESInt
    {
        return $this->max()->minus($this->min());
    }

    public function lowerBound(): ESInt
    {
        return $this->min();
    }

    public function upperBound(): ESInt
    {
        return $this->max();
    }

//-> Checking for containment
    public function contains(ESInt $int): ESBool
    {
        // TODO: Make ESInt loopable
        for ($i = $this->min()->int(); $i <= $this->max()->int(); $i++) {
            $check = ESInt::init($i);
            if ($int->isSameAs($check)->bool()) {
                return ESBool::init(true);
            }
        }
        return ESBool::init(false);
    }

//-> Clamping range
    public function clampedTo(ESRange $range): ESRange
    {
        // 10 vs 5 = 10
        $min = $this->min();
        if ($range->min()->isGreaterThan($min)) {
            $min = $range->min();
        }

        // 10 vs 500 = 10
        $max = $range->max();
        if ($this->max()->isLessThan($max)) {
            $max = $this->max();
        }
        return ESRange::init($min->int(), $max->int());
    }

//-> Equatable
    public function isSameAs(Equatable $compare): ESBool {}

    public function isNotSameAs(Equatable $compare): ESBool {}
}
