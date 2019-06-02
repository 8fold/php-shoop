<?php

namespace Eightfold\Shoop;

class ESRange extends ESBaseType implements
    \Iterator,
    \Countable
{
    private $min;

    private $max;

    private $includeLast;

    private $enumerated;

    public function __construct($min, $max, $includeLast = true)
    {
        $min = parent::sanitizeTypeOrTriggerError($min, "integer", ESInt::class);
        $max = parent::sanitizeTypeOrTriggerError($max, "integer", ESInt::class);
        $includeLast = parent::sanitizeTypeOrTriggerError($includeLast, "boolean", ESBool::class);
        $this->includeLast = $includeLast;

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
        return $this->spanIsGreaterThanZero();
    }

    private function spanIsGreaterThanZero()
    {
        if ($this->min()->unwrap() === 0 && $this->max()->unwrap() === 0) {
            return Shoop::bool(true);

        } elseif ($this->span()->unwrap() <= 0) {
            return Shoop::bool(true);

        }
        return Shoop::bool(false);
    }

    public function span(): ESInt
    {
        return $this->max()->minus($this->min());
    }

    public function unwrap()
    {
        return Shoop::tuple("min", $this->min(), "max", $this->max(), "closed", $this->includeLast);
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
        return ESArray::wrap(...range($this->min->unwrap(), $this->max->unwrap()));
    }

    /**
     * [overlaps description]
     * @param  [type]  $min         int|ESInt|ESRange
     * @param  [type]  $max         optional if min is ESRange
     * @param  boolean $includeLast optional if min is ESRange
     * @return [type]               [description]
     */
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

        $result = $this->min()->isLessThan($compare->max(), true)->unwrap() &&
            $this->max()->isGreaterThan($compare->min(), true)->unwrap();
        return ESBool::wrap($result);
    }

//-> Comparable
    public function isSameAs($compare): ESBool
    {
        return Shoop::bool(
            $this->min()->unwrap() === $compare->min()->unwrap() &&
            $this->max()->unwrap() === $compare->max()->unwrap()
        );
    }

//-> Countable
    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

//-> Iterator
    private function rangeAsValues(): ESArray
    {
        if (isset($this->rangeAsValues) && $this->rangeAsValues->count()->unwrap() > 0) {
            return $this->rangeAsValues;
        }

        $this->rangeAsValues = $this->enumerated();
        return $this->rangeAsValues();
    }

    public function current(): ESInt
    {
        return $this->rangeAsValues()->current();
    }

    public function key(): ESInt
    {
        return $this->rangeAsValues()->key();
    }

    public function next(): ESRange
    {
        $this->rangeAsValues()->next();
        return $this;
    }

    public function rewind(): ESRange
    {
        $this->rangeAsValues()->rewind();
        return $this;
    }

    public function valid(): bool
    {
        return $this->rangeAsValues()->valid();
    }
}
