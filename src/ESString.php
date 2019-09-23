<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\{
    Foldable,
    Convertable,
    Enumerable
};

class ESString extends ESBaseType
{
    use Foldable, Convertable, Enumerable;

    public function __construct($string)
    {
        if (is_string($string)) {
            $this->value = $string;

        } elseif (is_a($string, ESString::class)) {
            $this->value = $string->unfold();

        } else {
            $this->value = "";

        }
    }

    public function multipliedBy($multiplier): ESString
    {
        $multiplier = $this->sanitizeType($multiplier, "int", ESInt::class);
        return Shoop::string(str_repeat($this->unfold(), $multiplier->unfold()));
    }

    public function minus($string): ESString
    {
        $needle = $this->sanitizeType($string, "string", ESString::class)->unfold();
        return Shoop::string(str_replace($needle, "", $this->unfold()));
    }

    public function dividedBy($delimiter): ESArray
    {
        return $this->split($delimiter);
    }

    public function enumerate(): ESArray
    {
        return Shoop::array(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    public function plus($values)
        {
            $values = $this->sanitizeType($values, "string", ESString::class)
                ->unfold();
            return Shoop::string($this->unfold() . $values);
        }

    public function append($value)
    {
        return $this->plus($value);
    }

    public function prepend($value)
    {
        $value = $this->sanitizeType($value, "string", ESString::class);
        return Shoop::string($value . $this->unfold());
    }

    public function split($delimiter): ESArray
    {
        $delimiter = $this->sanitizeType($delimiter, "string", ESString::class);
        $exploded = explode($delimiter, $this->unfold());
        return Shoop::array($exploded)->removeEmptyValues();
    }

    public function lowerFirst(): ESString
    {
        return Shoop::string(lcfirst($this->value));
    }

//-> Checks
    public function beginsWith($string): ESBool
    {
        $string = $this->sanitizeType($string, "string", ESString::class);
        return $this->endsOrBeginsWith($string, 0);
    }

    public function doesNotBeginWith($string)
    {
        return $this->beginsWith($string)->toggle();
    }

    public function endsWith($string)
    {
        $string = $this->sanitizeType($string, "string", ESString::class);
        return $this->endsOrBeginsWith($string, $this->countUnfolded() - $string->countUnfolded());
    }

    private function endsOrBeginsWith($needle, int $start)
    {
        $return = Shoop::bool(
            substr($this->unfold(), $start, $needle->countUnfolded()) === $needle->unfold()
        );
        return $return;
    }

//-> String access
    public function __toString()
    {
        if (is_string($this->value)) {
            return $this->value;
        }
        return "";
    }
}
