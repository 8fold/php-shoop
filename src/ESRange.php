<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Equatable,
    Wrappable,
    EquatableImp
};

class ESRange implements \Iterator, \Countable, Equatable, Wrappable
{
    use EquatableImp;

    private $min;

    private $max;

    private $rangeAsValues = [];

    static public function wrap(...$args): ESRange
    {
        $min = (isset($args[0])) ? $args[0] : 0;
        $max = (isset($args[1])) ? $args[1] : 0;
        $includeLast = (isset($args[2])) ? $args[2] : true;
        return static::wrapRange($min, $max, $includeLast);
    }

    static public function wrapRange(int $min = 0, int $max = 0, bool $includeLast = true): ESRange
    {
        return new ESRange(
            ESInt::wrap($min),
            ESInt::wrap($max),
            ESBool::wrap($includeLast)
        );
    }

    public function __construct(ESInt $min, ESInt $max, ESBool $includeLast)
    {
        // TODO: Replace with ESTuple
        if ($min->isGreaterThan($max)->bool()) {
            $this->min = ESInt::wrap(0);
            $this->max = ESInt::wrap(0);

        } else {
            $this->min = $min;
            $this->max = ($includeLast->bool()) ? $max : $max->minus(ESInt::wrap(1));
        }

        $this->rangeAsValues = range($this->min->unwrap(), $this->max->unwrap());
    }

    public function unwrap()
    {
        return $this->rangeAsValues;
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
        return ESInt::wrap($this->rangeAsValues[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::wrap(key($this->rangeAsValues));
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
        return ESInt::wrap($first);
    }

    public function last(): ESInt
    {
        $last = array_pop($this->rangeAsValues);
        return ESInt::wrap($last);
    }

//-> Inspection
    public function isEmpty(): ESBool
    {
        if ($this->max()
            ->minus($this->min())
            ->isGreaterThan(ESInt::wrap(0))
            ->bool()
        ) {
            return ESBool::wrap(false);
        }
        return ESBool::wrap(true);
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
        for ($i = $this->min()->unwrap(); $i <= $this->max()->unwrap(); $i++) {
            $check = ESInt::wrap($i);
            if ($int->isSameAs($check)->bool()) {
                return ESBool::wrap(true);
            }
        }
        return ESBool::wrap(false);
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
        return ESRange::wrap($min->unwrap(), $max->unwrap());
    }

//-> Equatable
    public function isSameAs(Equatable $compare): ESBool
    {
        $min = $this->min()->isSameAs($compare->min());
        $max = $this->max()->isSameAs($compare->max());
        return $min->isSameAs($max);
    }
}
