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
    Compare,
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
    CompareImp,
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
    Compare,
    IsIn,
    Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, CompareImp, IsInImp, EachImp;

    static public function to(ESString $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpString::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return PhpString::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return PhpString::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpString::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return $instance->value();

        } elseif ($className === ESObject::class) {
            return PhpString::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return $instance->value();

        }
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

    // public function part($start, $length)
    // {

    // }

    public function replace($search, $replace, $occurences = -1): ESString
    {
        $search = Type::sanitizeType($search, ESString::class)->unfold();
        $replace = Type::sanitizeType($replace, ESString::class)->unfold();
        $occurences = Type::sanitizeType($occurences, ESInt::class)->unfold();
        $string = $this->stringUnfolded();
        $string = preg_replace("/". $search ."/", $replace, $string, $occurences);
        return Shoop::string($string);
    }

    public function trim($fromStart = true, $fromEnd = true, $charMask = " \t\n\r\0\x0B"): ESString
    {
        $fromStart = Type::sanitizeType($fromStart, ESBool::class)->unfold();
        $fromEnd = Type::sanitizeType($fromEnd, ESBool::class)->unfold();
        $charMask = Type::sanitizeType($charMask, ESString::class)->unfold();

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

    public function pathContent()
    {
        $path = $this->stringUnfolded();
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            if (strlen($contents) > 0) {
                return Shoop::string($contents);
            }
        }
        return Shoop::string("");
    }

    public function writeToPath($path)
    {
        $string = $this->stringUnfolded();
        $path = Type::sanitizeType($path, ESString::class)->unfold();
        $bytesOrFalse = file_put_contents($path, $string);
        if (is_bool($bytesOrFalse)) {
            return Shoop::bool($bytesOrFalse);

        }
        return Shoop::int($bytesOrFalse);
    }
}
