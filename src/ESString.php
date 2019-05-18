<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESInt,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Storeable,
    Describable,
    StoreableImp,
    DescribableImp,
    ComparableImp
};

class ESString extends ESBaseType implements
    Storeable,
    Describable
{
    use ComparableImp,
        StoreableImp,
        DescribableImp;

    private function bisectedArray($at): ESTuple
    {
        $at = parent::sanitizeTypeOrTriggerError($at, "integer", ESInt::class)->unwrap();
        return $this->enumerated()->dividedBy($at);
    }

    public function unwrap(): string
    {
        return $this->value;
    }

    public function enumerated(): ESArray
    {
        return ESArray::wrap(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

    private function join(array $array): ESString
    {
        return ESString::wrap(implode('', $array));
    }

    public function sorted(): ESString
    {
        return $this->join($this->enumerated()->sorted()->unwrap());
    }

    public function shuffled(): ESString
    {
        return $this->join($this->enumerated()->shuffled()->unwrap());
    }

    public function toggle(): ESString
    {
        return $this->join($this->enumerated()->toggle()->unwrap());
    }

    public function min(): ESString
    {
        return $this->enumerated()->min();
    }

    public function first(): ESString
    {
        return $this->min();
    }

    public function max(): ESString
    {
        return $this->enumerated()->max();
    }

    public function last(): ESString
    {
        return $this->max();
    }

    public function dropFirst($length): ESString
    {
        return $this->join($this->enumerated()->dropFirst($length)->unwrap());
    }

    public function dropLast($length): ESString
    {
        return $this->join($this->enumerated()->dropLast($length)->unwrap());
    }

    public function startsWith($compare): ESBool
    {
        $compare = parent::sanitizeTypeOrTriggerError($compare, "string", ESString::class)
            ->enumerated();
        return $this->enumerated()->startsWith($compare);
    }

    public function endsWith($compare): ESBool
    {
        $compare = parent::sanitizeTypeOrTriggerError($compare, "string", ESString::class)
            ->toggle();
        return $this->toggle()->startsWith($compare);
    }

    public function multipliedBy($multiplier): ESString
    {
        $multiplier = parent::sanitizeTypeOrTriggerError($multiplier, "integer", ESInt::class);
        return ESString::wrap(str_repeat($this->unwrap(), $multiplier->unwrap()));
    }

    public function dividedBy($delimiter): ESArray
    {
        $separator = parent::sanitizeTypeOrTriggerError($delimiter, "string", ESString::class);
        $array = ESArray::wrap(explode($delimiter, $this->unwrap()))->removeEmptyValues();
        return $array;
    }

    public function lowercased(): string
    {
        return mb_strtolower($this->value);
    }

    public function uppercased(): string
    {
        return mb_strtoupper($this->value);
    }

    public function characterAt($at): string
    {
        $at = parent::sanitizeTypeOrTriggerError($at, "integer", ESInt::class)->unwrap();
        $index = $at - 1;
        $array = $this->enumerated()->unwrap();
        return $array[$index];
    }

    public function plus($string): ESString
    {
        return ESString::wrap($this->unwrap() . parent::sanitizeTypeOrTriggerError($string, "string")->unwrap());
    }

    public function minus($string): ESString
    {
        $needle = parent::sanitizeTypeOrTriggerError($string, "string")->unwrap();
        return ESString::wrap(str_replace($needle, "", $this->unwrap()));
    }
}
