<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\Equatable;

class ESRange implements Equatable
{
    private $min;

    private $max;

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
            $this->max = ($includeLast->bool()) ? $max : $max->difference(1);
        }
    }

    public function min(): ESInt
    {
        return $this->min;
    }

    public function max(): ESInt
    {
        return $this->max;
    }

//-> Inspection
    public function isEmpty(): ESBool
    {
        if ($this->max()
            ->difference($this->min()->int())
            ->isGreaterThan(ESInt::init(0), true)
            ->bool()
        ) {
            return ESBool::init(false);
        }
        return ESBool::init(true);
    }

//-> Equatable
    public function isSameAs(Equatable $compare): ESBool {}

    public function isNotSameAs(Equatable $compare): ESBool {}
}
