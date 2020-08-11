<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use \Closure;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpString
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Arrayable // should be part of Shooped
    // MathOperations,
    // Toggle,
    // Shuffle,
    // Wrap,
    // Sort,
    // Has,
    // Drop,
    // IsIn,
    // Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    // ShuffleImp,
    // WrapImp,
    // SortImp,
    // HasImp,
    // DropImp,
    // IsInImp,
    // EachImp
};

class ESString implements
    Shooped,
    Arrayable
    // Shuffle,
    // Wrap,
    // Sort,
    // Drop,
    // Has, // TODO: Consider different implementation (array splits on letters, words become issues)
    // IsIn,
    // Each
{
    use ShoopedImp;// ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, IsInImp, EachImp;

    // static public function to(ESString $instance, string $className)
    // {
    //     if ($className === ESArray::class) {
    //         return PhpString::toIndexedArray($instance->main());

    //     } elseif ($className === ESBool::class) {
    //         return PhpString::toBool($instance->main());

    //     } elseif ($className === ESDictionary::class) {
    //         return PhpString::toAssociativeArray($instance->main());

    //     } elseif ($className === ESInt::class) {
    //         return PhpString::toInt($instance->main());

    //     } elseif ($className === ESJson::class) {
    //         return $instance->main();

    //     } elseif ($className === ESObject::class) {
    //         return PhpString::toObject($instance->main());

    //     } elseif ($className === ESString::class) {
    //         return $instance->main();

    //     }
    // }

    public function __construct($main)
    {
        $this->main = $main;
    }

// -> Type juggling

// -> Rearrange
    public function reverse($preserveMembers = true)
    {
        $array  = $this->array()->unfold();
        // $array->toggle()->join("") - this has caused issues in the passed
        $array  = array_reverse($array);
        $string = implode("", $array);
        return static::fold($string);
    }

// -> Math operations
    // TODO: PHP 8.0 - string|ESString
    public function plus(...$terms): ESString
    {
        $string = $this->main;
        foreach ($terms as $term) {
            if (! is_string($term) and !is_a($term, ESString::class)) {
                $this->typeError("All terms must be", "string or ESString", "plus()", print_r($terms, true));
            }
            $string .= $term;
        }
        return static::fold($string);
    }

    /**
     * @see stripAll()
     */
    // TODO: PHP 8.0 - string|ESString
    public function minus(...$terms): ESString
    {
        return $this->strip(implode("", $terms), false, false);
    }

    // TODO: PHP 8.0 - int|ESInt
    public function multiply($multiplier = 1)
    {
        if (! is_int($multiplier) and ! is_a($multiplier, ESInt::class)) {
            $this->typeError(1, "integer or ESInt", "stripFirst()", gettype($length));
        }

        $string = str_repeat($this->main, $multiplier);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - string|int|ESString|ESInt, bool|ESBool, int|ESInt
    public function divide(
        $divisor = 0,
        $includeEmpties = true,
        $limit = PHP_INT_MAX
    ): ESArray
    {
        $array = Php::stringSplitOn(
            $this->main,
            $divisor,
            $includeEmpties,
            $limit
        );
        return ESArray::fold($array);
    }

// -> Replacements
    // TODO: PHP 8.0 array|ESDictionary = $replacements bool|ESBool = $caseSensitive
    public function replace($replacements = [], $caseSensitive = true): ESString
    {
        if (! $this->isDictionary($replacements)) {
            $this->typeError(1, "associative array or ESDictionary", "replace()", print_r($replacements, true));
        }

        if (! $this->isDictionary($replacements)) {
            $this->typeError(1, "bool or ESBool", "replace()", gettype($caseSensitive));
        }

        $search = array_keys($replacements);
        $replace = array_values($replacements);
        if ($caseSensitive) {
            $string = str_replace($search, $replace, $this->main);
            return static::fold($string);

        }
        $string = str_ireplace($search, $replace, $this->main);
        return static::fold($string);
    }

// -> Strip characters
    // TODO: PHP 8.0 bool|ESBool, bool|ESBool, string|ESString
    /**
     * |           |From end |From start |Result                                                  |
     * |From end   |true     |true       |Characters are removed from beginning & end, not middle |
     * |From start |false    |false      |All characters are moved from string                    |
     * |Result     |Characters are stripped from end, not beginning |Characters are stripped from beginning, not end ||
     * @param  string  $charMask  [description]
     * @param  boolean $fromEnd   [description]
     * @param  boolean $fromStart [description]
     * @return [type]             [description]
     */
    public function strip(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    ): ESString
    {
        $string = Php::stringStrippedOf($this->main, $fromEnd, $fromStart, $charMask);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - Stringable
    public function stripTags(...$allow): ESString
    {
        $string = Php::stringStrippedOfTags($this->main, ...$allow);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - int|ESInt
    public function stripFirst($length = 1): ESString
    {
        if (! is_int($length) and ! is_a($length, ESInt::class)) {
            $this->typeError(1, "integer or ESInt", "stripFirst()", gettype($length));
        }

        $sLength = strlen($this->main) - $length;
        $string = substr($this->main, $length, $sLength);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - int|ESInt
    public function stripLast($length = 1): ESString
    {
        if (! is_int($length) and ! is_a($length, ESInt::class)) {
            $this->typeError(1, "integer or ESInt", "stripFirst()", gettype($length));
        }

        $sLength = strlen($this->main) - $length;
        $string = substr($this->main, 0, $sLength);
        return static::fold($string);
    }

// -> Case changes
    public function lowercase(): ESString
    {
        $string = Php::stringToLowercase($this->main);
        return static::fold($string);
    }

    public function uppercase(): ESString
    {
        $string = Php::stringToUppercase($this->main);
        return static::fold($string);
    }

    public function lowerFirst(): ESString
    {
        $string = Php::stringToLowercaseFirst($this->main);
        return static::fold($string);
    }

// -> Arrayable
    public function array(): ESArray
    {
        $array = Php::stringToArray($this->main);
        return ESArray::fold($array);
    }

    // TODO: PHP 8.0 - int|ESInt -> any|ESBool
    public function hasMember($member, Closure $closure = null)
    {
        if (! is_int($member) and ! is_a($member, ESInt::class)) {
            $this->typeError(1, "integer or ESInt", "stripFirst()", gettype($member));
        }

        $bool = $this->offsetExists($member);
        if ($closure === null) {
            return ESBool::fold($bool);
        }
        return $closure($bool, static::fold($this->main));
    }

    public function offsetExists($offset): bool
    {
        return isset($this->main[$offset]);
    }


// -> Deprecated
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

    /**
     * @deprecated - Use strip() instead
     */
    public function trim(
        $fromStart = true,
        $fromEnd = true,
        $charMask = " \t\n\r\0\x0B"
    ): ESString
    {
        return $this->strip($charMask, $fromEnd, $fromStart);
    }

    /**
     * @deprecated - Use stripTags() instead
     */
    public function dropTags(...$allow): ESString
    {
        return $this->stripTags(...$allow);
    }

    /**
     * @deprecated - Not used in projects maintained by 8fold
     */
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

    /**
     * @deprecated - Use reverse
     */
    public function toggle($preserveMembers = true)
    {
        return $this->reverse($preserveMembers);
    }

// -> Utilities
    private function isDictionary(array $potential = []): bool
    {
        if (is_a($potential, ESDictionary::class)) {
            return true;
        }

        $members = array_keys($potential);
        $firstMember = array_shift($members);
        if (is_int($firstMember) and $firstMember === 0) {
            return false;
        }
        $cast = (string) $firstMember;
        return is_string($cast);
    }

    private function typeError(
        string $argNumber,
        string $expectedType,
        string $method,
        string $givenType
    ): void
    {
        $class = get_class($this); // TODO: PHP 8.0 - $this::class
        trigger_error("Argument {$argNumber} must be of type {$expectedType} in {$class}::{$method}: {$givenType} given.");
    }
}
