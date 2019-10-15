<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

class ESString implements Shooped
{
    use ShoopedImp;

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

    public function array(): ESArray
    {
        return Shoop::array(preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
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

    // TODO: Test
    public function toggle()
    {
        return $this->array()->toggle()->join("");
    }

    public function sort()
    {
        $array = $this->array()->unfold();
        natsort($array);
        return Shoop::array($array)->join("");
    }

    public function shuffle()
    {
        $array = $this->array()->unfold();
        shuffle($array);
        return Shoop::array($array)->join("");
    }

    public function start(...$prefixes)
    {
        $combined = implode('', $prefixes);
        return Shoop::string($combined . $this->unfold());
    }

    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESString::class);
        $substring = substr($this->unfold(), 0, $needle->countUnfolded());
        return Shoop::bool($substring === $needle->unfold());
    }

    /**
     * @deprecated
     */
    public function beginsWith($string): ESBool
    {
        return $this->startsWith($string);
    }

    /**
     * @deprecated
     */
    public function doesNotBeginWith($string)
    {
        return $this->doesNotStartWith($string);
    }

    public function plus(...$args)
    {
        $total = $this->value;
        $terms = $args;
        foreach ($terms as $term) {
            $term = Type::sanitizeType($term, ESString::class)->unfold();
            $total .= $term;
        }

        return Shoop::string($total);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESString::class)->toggle();
        $reversed = $this->toggle();
        return $reversed->startsWith($needle);
    }

    /**
     * @deprecated
     */
    public function prepend(...$args)
    {
        return $this->start(...$args);
    }

    public function minus(...$args): ESString
    {
        $needle = Type::sanitizeType($args[0], ESString::class)->unfold();
        return Shoop::string(str_replace($needle, "", $this->unfold()));
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return Shoop::string(str_repeat($this->unfold(), $int));
    }

    public function divide($divisor = null, $removeEmpties = true)
    {
        if ($divisor === null) {
            return Shoop::array([]);
        }

        $divisor = Type::sanitizeType($divisor, ESString::class);
        $removeEmpties = Type::sanitizeType($removeEmpties);

        $exploded = explode($divisor, $this);
        $shooped = Shoop::array($exploded);

        if ($removeEmpties->unfold()) {
            $shooped = $shooped->removeEmptyValues();
        }
        return $shooped;
    }

    public function split($splitter, $splits = 2): ESArray
    {
        $splitter = Type::sanitizeType($splitter, ESString::class)->unfold();
        $splits = Type::sanitizeType($splits, ESInt::class)->unfold();
        return Shoop::array(explode($splitter, $this->unfold(), $splits));
    }

    public function lowerFirst(): ESString
    {
        return Shoop::string(lcfirst($this->value));
    }

    public function uppercase(): ESString
    {
        return Shoop::string(strtoupper($this->value));
    }

    public function pathContent()
    {
        // rename fileContents()
        //        saveFileContents($path)
        // dd($this->unfold());
        if (is_file($this->unfold())) {
            return Shoop::string(file_get_contents($this->unfold()));
        }
        return Shoop::string("");
    }




























}
