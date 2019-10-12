<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

class ESString implements Shooped
{
    use ShoopedImp;

    public function enumerate(): ESArray
    {
        return Shoop::array(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    // TODO: Test
    public function toggle()
    {
        return $this->enumerate()->toggle()->join("");
    }

    public function plus(...$args)
    {
        $total = $this->value;
        $terms = $args;
        foreach ($terms as $term) {
            $term = $this->sanitizeType($term, ESString::class)->unfold();
            $total .= $term;
        }

        return Shoop::string($total);
    }

    public function minus($string): ESString
    {
        $needle = $this->sanitizeType($string, ESString::class)->unfold();
        return Shoop::string(str_replace($needle, "", $this->unfold()));
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return Shoop::string(str_repeat($this->unfold(), $int));
    }

    public function divide($value = null)
    {
        if ($value === null) {
            return $this;
        }

        $value = Type::sanitizeType($value, ESString::class)->unfold();
        return Shoop::array(explode($value, $this->unfold(), 2));
    }

    public function isDivisible($value): ESBool
    {
        $splitter = $this->sanitizeType($value, ESString::class);
        return Shoop::bool(count(explode($splitter, $this->unfold())) > 0);
    }

    public function isGreaterThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESString::class)->unfold();
        return $this->unfold() > $compare;
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESString::class)->unfold();
        return $this->unfold() >= $compare;
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESString::class)->unfold();
        return $this->unfold() < $compare;
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESString::class)->unfold();
        return $this->unfold() <= $compare;
    }

    public function prepend(...$args)
    {
        $total = implode('', $args);
        return Shoop::string($total . $this->unfold());
    }














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

    public function split($delimiter): ESArray
    {
        $delimiter = $this->sanitizeType($delimiter, ESString::class);
        $exploded = explode($delimiter, $this->unfold());
        return Shoop::array($exploded)->removeEmptyValues();
    }

    public function lowerFirst(): ESString
    {
        return Shoop::string(lcfirst($this->value));
    }

    public function uppercase(): ESString
    {
        return Shoop::string(strtoupper($this->value));
    }

//-> Checks
    public function beginsWith($string): ESBool
    {
        $string = $this->sanitizeType($string, ESString::class);
        return $this->endsOrBeginsWith($string, 0);
    }

    public function doesNotBeginWith($string)
    {
        return $this->beginsWith($string)->toggle();
    }

    public function endsWith($string)
    {
        $string = $this->sanitizeType($string, ESString::class);
        return $this->endsOrBeginsWith(
            $string,
            $this->countUnfolded() - $string->countUnfolded()
        );
    }

    private function endsOrBeginsWith($needle, int $start)
    {
        $return = Shoop::bool(
            substr(
                $this->unfold(),
                $start,
                $needle->countUnfolded()) === $needle->unfold()
        );
        return $return;
    }

    public function pathContent()
    {
        // dd($this->unfold());
        if (is_file($this->unfold())) {
            return Shoop::string(file_get_contents($this->unfold()));
        }
        return Shoop::string("");
    }

//-> String access
    // public function __toString()
    // {
    //     return (string) $this->unfold();
    // }
}
