<?php

namespace Eightfold\Shoop;

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
    IsIn
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
    IsInImp
};

use Eightfold\Shoop\Helpers\Type;

// TODO: replace(x, y)
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
    IsIn
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, CompareImp, IsInImp;

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

    public function replace($search, $replace, $occurences = -1): ESString
    {
        $search = Type::sanitizeType($search, ESString::class)->unfold();
        $replace = Type::sanitizeType($replace, ESString::class)->unfold();
        $occurences = Type::sanitizeType($occurences, ESInt::class)->unfold();
        $string = $this->value;
        $string = preg_replace("/". $search ."/", $replace, $string, $occurences);
        return Shoop::string($string);
    }

    public function lowerFirst(): ESString
    {
        $string = $this->value;
        $string = lcfirst($string);
        return Shoop::string($string);
    }

    public function uppercase(): ESString
    {
        $string = $this->value;
        $string = strtoupper($string);
        return Shoop::string($string);
    }

    public function pathContent()
    {
        $string = $this->value;
        $isFile = is_file($string);
        if ($isFile) {
            $contents = file_get_contents($string);
            return Shoop::string($contents);
        }
        return Shoop::string("");
    }

    public function writeToPath($path)
    {
        $string = $this->value;
        $path = Type::sanitizeType($path, ESString::class)->unfold();
        $bytesOrFalse = file_put_contents($path, $string);
        if (is_bool($bytesOrFalse)) {
            return Shoop::bool($bytesOrFalse);

        }
        return Shoop::int($bytesOrFalse);
    }
}
