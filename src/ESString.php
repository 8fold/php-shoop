<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpString
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
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
    // MathOperationsImp,
    // ToggleImp,
    // ShuffleImp,
    // WrapImp,
    // SortImp,
    // HasImp,
    // DropImp,
    // IsInImp,
    // EachImp
};

class ESString implements
    Shooped
    // MathOperations,
    // Toggle,
    // Shuffle,
    // Wrap,
    // Sort,
    // Drop,
    // Has, // TODO: Consider different implementation (array splits on letters, words become issues)
    // IsIn,
    // Each
{
    use ShoopedImp;//, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, IsInImp, EachImp;

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
        return $this->stripAll(...$terms);
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
    )
    {
        if (! is_string($divisor) and ! is_a($divisor, ESString::class)) {
            $this->typeError(1, "string or ESString", "divide()", gettype($divisor));
        }

        if (! is_bool($includeEmpties) and ! is_a($includeEmpties, ESBool::class)) {
            $this->typeError(2, "bool or ESBool", "divide()", gettype($includeEmpties));
        }

        if (! $limit !== PHP_INT_MAX and ! is_int($limit) and ! is_a($limit, ESBool::class)) {
            $this->typeError(3, "int or ESInt", "divide()", gettype($limit));
        }

        $array = explode($divisor, $this->main, $limit);
        if (! $includeEmpties) {
            $array = array_filter($array);
            $array = array_values($array);
        }
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
    public function strip(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    ): ESString
    {
        if (! is_string($charMask) and ! is_a($charMask, ESString::class)) {
            $this->typeError(1, "string or ESString", "strip()", gettype($charMask));
        }

        if (! is_bool($fromEnd) and ! is_a($fromEnd, ESBool::class)) {
            $this->typeError(3, "bool or ESBool", "strip()", gettype($fromEnd));
        }

        if (! is_bool($fromStart) and ! is_a($fromStart, ESBool::class)) {
            $this->typeError(3, "bool or ESBool", "strip()", gettype($fromEnd));
        }

        $string = $this->main;
        if ($fromStart and $fromEnd) {
            $string = trim($string, $charMask);

        } elseif ($fromStart and ! $fromEnd) {
            $string = ltrim($string, $charMask);

        } elseif (! $fromStart and $fromEnd) {
            $string = rtrim($string, $charMask);

        }
        return static::fold($string);
    }

    // TODO: PHP 8.0 - Stringable
    public function stripAll(...$terms): ESString
    {
        $string = str_replace($terms, "", $this->main);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - Stringable
    public function stripTags(...$allow): ESString
    {
        $allow = implode("", $allow);
        $string = strip_tags($this->main, $allow);
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
        $string = strtolower($this->main);
        return static::fold($string);
    }

    public function uppercase(): ESString
    {
        $string = strtoupper($this->main);
        return static::fold($string);
    }

    public function lowerFirst(): ESString
    {
        $string = lcfirst($this->main);
        return static::fold($string);
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
