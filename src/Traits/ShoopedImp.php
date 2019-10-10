<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

trait ShoopedImp
{
    private function sanitizeType($toSanitize, string $shoopType = "")
    {
        return Type::sanitizeType($toSanitize, $shoopType);
    }

    protected $value;

    static public function fold($value): self
    {
        return new static($value);
    }

    public function unfold()
    {
        return $this->value;
    }

//-> Getters
    public function __call(string $name, array $args = [])
    {
        $call = $this->knownMethodFromUnknownName($name);
        $result = $this->{$call}(...$args);
        if (Type::isShooped($result)) {
            return $result->unfold();
        }
        return $result;
    }

    private function knownMethodFromUnknownName(string $name)
    {
        $call = "";
        $start = strlen($name) - strlen("Unfolded");
        $isFolded = $this->methodNameContains("Unfolded", $name, $start);
        if ($isFolded) {
            $call = lcfirst(substr_replace($name, "", $start, strlen($name) - $start));
        }

        if (strlen($call) === 0) {
            $className = static::class;
            trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);
        }
        return $call;
    }

    private function methodNameContains(string $needle, string $haystack, int $start)
    {
        $needle = $needle;
        $end = strlen($haystack);
        $len = strlen($needle);
        return substr($haystack, $start, $len) === $needle;
    }

//-> Enumerable
    public function count(): ESInt
    {
        return Shoop::int(count($this->enumerate()->unfold()));
    }

    public function countIsGreaterThan($value): ESBool
    {
        $value = $this->sanitizeType($value, ESInt::class)
            ->unfold();
        return $this->count()->isGreaterthan($value);
    }

    public function countIsNotGreaterThan($value): ESBool
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isLessThanOrEqual($value);
    }

    public function countIsLessThan($value): ESBool
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isLessThan($value);
    }

    public function countIsNotLessThan($value): ESBool
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isGreaterThanOrEqual($value);
    }

//-> Checks
    public function isEmpty(): ESBool
    {
        $result = empty($this->unfold());
        return Shoop::bool($result);
    }

    public function isArray(): ESBool
    {
        return Type::isArray($this);
    }

    public function isNotArray(): ESBool
    {
        return Type::isNotArray($this);
    }

    public function isSame($compare): ESBool
    {
        if (Type::isNotShooped($compare)) {
            $compare = $this->sanitizeType($compare);

        }
        return Shoop::bool($this->unfold() === $compare->unfold());
    }

    public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }

//-> Other
    // TODO: test
    public function append(...$args)
    {
        return $this->plus(...$args);
    }

    public function prepend(...$args)
    {
        return $this->plus(...$ags);
    }

}
