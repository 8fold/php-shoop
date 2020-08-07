<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpString
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Has,
    Drop,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    HasImp,
    DropImp,
    IsInImp,
    EachImp
};

class ESString implements
    Shooped,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has, // TODO: Consider different implementation (array splits on letters, words become issues)
    IsIn,
    Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, IsInImp, EachImp;

    static public function to(ESString $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpString::toIndexedArray($instance->main());

        } elseif ($className === ESBool::class) {
            return PhpString::toBool($instance->main());

        } elseif ($className === ESDictionary::class) {
            return PhpString::toAssociativeArray($instance->main());

        } elseif ($className === ESInt::class) {
            return PhpString::toInt($instance->main());

        } elseif ($className === ESJson::class) {
            return $instance->main();

        } elseif ($className === ESObject::class) {
            return PhpString::toObject($instance->main());

        } elseif ($className === ESString::class) {
            return $instance->main();

        }
    }

    static public function processedMain($main): string
    {
        if (is_string($main)) {
            $main = $main;

        } elseif (is_a($main, ESString::class)) {
            $main = $main->unfold();

        } else {
            $main = "";

        }
        return $main;
    }

    public function dropTags(...$allow): ESString
    {
        $allow = implode("", $allow);
        $string = strip_tags($this->main(), $allow);
        return Shoop::string($string);
    }

    // TODO: PHP 8.0 array|ESDictionary = $replacements bool|ESBool = $caseSensitive
    public function replace($replacements = [], $caseSensitive = true): ESString
    {
        $replacements  = Type::sanitizeType($replacements, ESDictionary::class)->unfold();
        $caseSensitive = Type::sanitizeType($caseSensitive, ESBool::class)->unfold();

        $search = array_keys($replacements);
        $replace = array_values($replacements);
        if ($caseSensitive) {
            $string = str_replace($search, $replace, $this->main());
            return Shoop::string($string);

        }
        $string = str_ireplace($search, $replace, $this->main());
        return Shoop::string($string);
    }

    // TODO: PHP 8.0 string|ESString, int|ESInt, int|ESInt
    public function replaceRange($replacement, $start = 0, $length = null): ESString
    {
        $replacement = Type::sanitizeType($replacement, ESString::class)->unfold();
        $start = Type::sanitizeType($start, ESInt::class)->unfold();
        $length = ($length === null)
            ? Type::sanitizeType(strlen($replacement), ESInt::class)->unfold()
            : Type::sanitizeType($length, ESInt::class)->unfold();

        $string = substr_replace($this->main(), $replacement, $start, $length);
        return Shoop::string($string);
    }

    // TODO: PHP 8.0 bool|ESBool, bool|ESBool, string|ESString
    public function trim($fromStart = true, $fromEnd = true, $charMask = " \t\n\r\0\x0B"): ESString
    {
        $fromStart = Type::sanitizeType($fromStart, ESBool::class)->unfold();
        $fromEnd   = Type::sanitizeType($fromEnd, ESBool::class)->unfold();
        $charMask  = Type::sanitizeType($charMask, ESString::class)->unfold();

        $string = $this->stringUnfolded();
        $trimmed = $string;
        if ($fromStart and $fromEnd) {
            $trimmed = trim($string, $charMask);

        } elseif ($fromStart and ! $fromEnd) {
            $trimmed = ltrim($string, $charMask);

        } elseif (! $fromStart and $fromEnd) {
            $trimmed = rtrim($string, $charMask);

        }
        return Shoop::string($trimmed);
    }

    public function lowerFirst(): ESString
    {
        $string = $this->stringUnfolded();
        $string = lcfirst($string);
        return Shoop::string($string);
    }

    public function uppercase(): ESString
    {
        $string = $this->stringUnfolded();
        $string = strtoupper($string);
        return Shoop::string($string);
    }

    /**
     * @deprecated - move to extras URL
     */
    public function urlencode(): ESString
    {
        $string = $this->stringUnfolded();
        $string = urlencode($string);
        return Shoop::string($string);
    }

    /**
     * @deprecated - move to extras URL
     */
    public function urldecode(): ESString
    {
        $string = $this->stringUnfolded();
        $string = urldecode($string);
        return Shoop::string($string);
    }
}
