<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESInt,
    ESBool
};

class ESString extends ESBaseType
{
    public function unwrap(): string
    {
        return $this->value;
    }

    public function enumerated(): ESArray
    {
        return ESArray::wrap(...preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    public function count(): ESInt
    {
        return $this->enumerated()->count();
    }

    public function description(): ESString
    {
        return $this;
    }

    public function plus($string): ESString
    {
        return ESString::wrap($this->unwrap() . parent::sanitizeTypeOrTriggerError($string, "string")->unwrap());
    }

    public function multipliedBy($multiplier): ESString
    {
        $multiplier = parent::sanitizeTypeOrTriggerError($multiplier, "integer", ESInt::class);
        return ESString::wrap(str_repeat($this->unwrap(), $multiplier->unwrap()));
    }

    public function minus($string): ESString
    {
        $needle = parent::sanitizeTypeOrTriggerError($string, "string")->unwrap();
        return ESString::wrap(str_replace($needle, "", $this->unwrap()));
    }

    public function dividedBy($delimiter): ESArray
    {
        return $this->split($delimiter);
    }

    public function split($delimiter): ESArray
    {
        $separator = parent::sanitizeTypeOrTriggerError($delimiter, "string", ESString::class);
        $exploded = explode($delimiter, $this->unwrap());
        return ESArray::wrap(...$exploded)->removeEmptyValues();
    }
}
