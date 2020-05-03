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
    Compare
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
    CompareImp
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
    Compare
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, CompareImp;

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

// - Type Juggling
// - PHP single-method interfaces
// - Math language
// - Comparison
// - Getters
    // public function get($member)
    // {
    //     $member = Type::sanitizeType($member, ESInt::class)->unfold();
    //     if ($this->offsetExists($member)) {
    //         $m = $this->value[$member];
    //         return ((Type::isPhp($m))) ? Type::sanitizeType($m) : $m;
    //     }
    //     trigger_error("Undefined index or member.");
    // }

    // TODO: Could this be promoted to the hasImp - or a global contract?
    public function isIn($haystack): ESBool
    {
        $bool = false;
        foreach ($this->array() as $needle) {
            if ($this->hasUnfolded($needle)) {
                $bool = true;
                break;
            }
        }
        return Shoop::bool($bool);
    }

// - Manipulate
    // public function toggle($preserveMembers = true)
    // {
    //     return $this->array()->toggle()->join("");
    // }

    // TODO: test and verify occurences working
    // str_replace is the wrong function to use for this
    public function replace($search, $replace, $occurences = 0): ESString
    {
        return Shoop::string(str_replace($search, $replace, $this->unfold(), $occurences));
    }

// - Wrap
// - Split
    public function split($splitter = 1, $splits = 2): ESArray
    {
        $splitter = Type::sanitizeType($splitter, ESString::class)->unfold();
        $splits = Type::sanitizeType($splits, ESInt::class)->unfold();
        return Shoop::array(explode($splitter, $this->unfold(), $splits));
    }

// - Replace
// - Other
    public function lowerFirst(): ESString
    {
        // ?? lower(1, 3, 4) : lower("even") : lower("odd")
        return Shoop::string(lcfirst($this->value));
    }

    public function uppercase(): ESString
    {
        return Shoop::string(strtoupper($this->value));
    }

    public function pathContent()
    {
        if (is_file($this->unfold())) {
            return Shoop::string(file_get_contents($this->unfold()));
        }
        return Shoop::string("");
    }

    public function writeToPath($path)
    {
        $path = Type::sanitizeType($path, ESString::class)->unfold();
        return Shoop::int(file_put_contents($path, $this->unfold()));
    }

// - Transforms
// - Callers
// -> Array Access
}
