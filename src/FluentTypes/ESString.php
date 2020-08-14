<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use \Countable;
use \JsonSerializable;

use Eightfold\Shoop\Php;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Contracts\Typeable; // Shoop??
use Eightfold\Shoop\Contracts\TypeableImp;

use Eightfold\Shoop\Contracts\Arrayable; // Shoop??
use Eightfold\Shoop\Contracts\ArrayableImp;

use Eightfold\Shoop\Contracts\Strippable;
use Eightfold\Shoop\Contracts\StrippableImp;

use Eightfold\Shoop\Php\AsArrayFromString;
use Eightfold\Shoop\Php\Plus;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpString
};

class ESString implements
    Shooped,
    Arrayable,
    Strippable,
    Typeable
    // Shuffle,
    // Wrap,
    // Sort,
    // Drop,
    // Has, // TODO: Consider different implementation (array splits on letters, words become issues)
    // IsIn,
    // Each
{
    use ShoopedImp, ArrayableImp, StrippableImp, TypeableImp;// ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp, DropImp, IsInImp, EachImp;

    // // TODO: PHP 8.0 - string|ESString
    // public function __construct($main)
    // {
    //     $this->main = $main;
    // }

// -> Rearrange
    // TODO: PHP 8.0 - bool|ESBool
    public function reverse($preserveMembers = true)
    {
        $string = Php::stringReversed($this->main);
        return static::fold($string);
    }

// -> Math operations
    // TODO: PHP 8.0 - string|ESString
    public function plus(...$terms): ESString
    {
        $string = Shoop::pipe($this->main, Plus::applyWith(...$terms))
            ->unfold();
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
        $string = Php::stringRepeated($this->main, $multiplier);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - string|int|ESString|ESInt, bool|ESBool, int|ESInt
    public function divide(
        $divisor = 0,
        $includeEmpties = true,
        $limit = PHP_INT_MAX
    ): ESArray
    {
        $array = Shoop::pipe($this->main,
            AsArrayFromString::applyWith($divisor, $includeEmpties, $limit)
        )->unfold();
        // $array = Php::stringSplitOn(
        //     $this->main,
        //     $divisor,
        //     $includeEmpties,
        //     $limit
        // );
        return ESArray::fold($array);
    }

// -> Replacements
    // TODO: PHP 8.0 array|ESDictionary = $replacements bool|ESBool = $caseSensitive
    public function replace($replacements = [], $caseSensitive = true): ESString
    {
        $string = Php::stringAfterReplacing($this->main, $replacements, $caseSensitive);
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
