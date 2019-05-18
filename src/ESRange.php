<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESTypeMap,
    ESBaseType,
    ESArray,
    ESInt
};

class ESRange extends ESBaseType implements
    \Iterator,
    \Countable
{
    private $min;

    private $max;

    private $rangeAsValues = [];

    public function __construct($min, $max, $includeLast = true)
    {
        // TODO: Replace with ESTuple
        $min = parent::sanitizeTypeOrTriggerError($min, "integer", ESInt::class);
        $max = parent::sanitizeTypeOrTriggerError($max, "integer", ESInt::class);
        $includeLast = parent::sanitizeTypeOrTriggerError($includeLast, "boolean", ESBool::class);


        if ($min->isGreaterThan($max)->bool()) {
            $this->min = ESInt::wrap(0);
            $this->max = ESInt::wrap(0);

        } else {
            $this->min = $min;
            $this->max = ($includeLast->bool()) ? $max : $max->minus(ESInt::wrap(1));
        }
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

    public function enumerated(): ESArray
    {
        return ESArray::wrap(range($this->min->unwrap(), $this->max->unwrap()));
    }

    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

//-> Iterator
    private function rangeAsValues(): array
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        return $this->rangeAsValues;
    }

    public function current(): ESInt
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        $current = key($this->rangeAsValues);
        return ESInt::wrap($this->rangeAsValues[$current]);
    }

    public function key(): ESInt
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        return ESInt::wrap(key($this->rangeAsValues));
    }

    public function next(): ESRange
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        next($this->rangeAsValues);
        return $this;
    }

    public function rewind(): ESRange
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        reset($this->rangeAsValues);
        return $this;
    }

    public function valid(): bool
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        $key = key($this->rangeAsValues);
        $var = ($key !== null && $key !== false);
        return $var;
    }

//-> Accessing elements
    public function first(): ESInt
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
        $first = array_shift($this->rangeAsValues);
        return ESInt::wrap($first);
    }

    public function last(): ESInt
    {
        if (count($this->rangeAsValues) === 0) {
            $this->rangeAsValues = $this->enumerated()->unwrap();
        }
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

    public function lowerBound(): ESInt
    {
        return $this->min();
    }

    public function upperBound(): ESInt
    {
        return $this->max();
    }

    public function overlaps($min, $max = null, $includeLast = true): ESBool
    {
        if (is_a($min, ESRange::class)) {
            $compare = $min;

        } else {
            $min = parent::sanitizeTypeOrTriggerError($min, "integer", ESInt::class);
            $max = parent::sanitizeTypeOrTriggerError($max, "integer", ESInt::class);
            $includeLast = parent::sanitizeTypeOrTriggerError($includeLast, "boolean", ESBool::class);
            $compare = ESRange::wrap($min, $max, $includeLast);
        }

        // max1 >= min2
        // max2 >= min1
        // 20 ?? 10
        // 10 ?? 1

        $result = $this->min()->isLessThan($compare->max(), true)->unwrap() &&
            $this->max()->isGreaterThan($compare->min(), true)->unwrap();
        return ESBool::wrap($result);
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
    // public function isSameAs(Equatable $compare): ESBool
    // {
    //     $min = $this->min()->isSameAs($compare->min());
    //     $max = $this->max()->isSameAs($compare->max());
    //     return $min->isSameAs($max);
    // }
}
