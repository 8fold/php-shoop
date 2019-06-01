<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
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
        $min = parent::sanitizeTypeOrTriggerError($min, "integer", ESInt::class);
        $max = parent::sanitizeTypeOrTriggerError($max, "integer", ESInt::class);
        $includeLast = parent::sanitizeTypeOrTriggerError($includeLast, "boolean", ESBool::class);

        if ($min->isGreaterThan($max)->unwrap()) {
            $this->min = ESInt::wrap(0);
            $this->max = ESInt::wrap(0);

        } else {
            $this->min = $min;
            $this->max = ($includeLast->unwrap())
                ? $max
                : $max->minus(ESInt::wrap(1));
        }
    }

    public function isEmpty(): ESBool
    {
        if ($this->max()
            ->minus($this->min())
            ->isGreaterThan(ESInt::wrap(0))
            ->unwrap()
        ) {
            return ESBool::wrap(false);
        }
        return ESBool::wrap(true);
    }

    public function unwrap()
    {
        return $this->rangeAsValues();
    }

    public function min(): ESInt
    {
        return $this->min;
    }

    public function max(): ESInt
    {
        return $this->max;
    }

    public function random(): ESInt
    {
        return ESInt::wrap(rand($this->min->unwrap(), $this->max->unwrap()));
    }

    public function enumerated(): ESArray
    {
        return ESArray::wrap(range($this->min->unwrap(), $this->max->unwrap()));
    }

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

//-> Countable
    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

//-> Iterator
    private function rangeAsValues(): array
    {
        if (count($this->rangeAsValues) > 0) {
            return $this->rangeAsValues;
        }
        $this->rangeAsValues = $this->enumerated()->unwrap();
        return $this->rangeAsValues();
    }

    public function current(): ESInt
    {
        $values = $this->rangeAsValues();
        $current = key($values);
        return ESInt::wrap($values[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::wrap(key($this->rangeAsValues()));
    }

    public function next(): ESRange
    {
        $this->rangeAsValues();
        next($this->rangeAsValues);
        return $this;
    }

    public function rewind(): ESRange
    {
        $this->rangeAsValues();
        reset($this->rangeAsValues);
        return $this;
    }

    public function valid(): bool
    {
        $key = key($this->rangeAsValues());
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
