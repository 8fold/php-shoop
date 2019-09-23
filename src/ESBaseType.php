<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Shoop;

/**
 * Attention maintainers: Do not use Shoop classess and methods
 * within this class as it can cause memory overflow exceptions.
 */
class ESBaseType implements \Countable
{
    protected $value;

    static public function fold($args): ESBaseType
    {
        return new static($args);
    }

    public function __construct(...$args)
    {
        $this->value = $args[0];
    }

    public function unfold()
    {
        return $this->value;
    }

//-> Getters
    public function __call(string $name, array $args = [])
    {
        $call = $this->callFromName($name);
        $result = $this->{$call}(...$args);
        if ($result === null) {
            return null;

        } elseif (static::isShoop($result)) {
            return $result->unfold();

        }
        return $result;
    }

    private function callFromName(string $name)
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

//-> Comparison safer to use Shoop
    static public function isShoop($potential): bool
    {
        return is_subclass_of($potential, ESBaseType::class);
    }

    static protected function isAssociativeArray($value): bool
    {
        if (is_array($value)) {
            return array_keys($value) !== range(0, count($value) - 1);
        }
        return false;
    }

    public function isEmpty(): ESBool
    {
        $result = empty($this->unfold());
        return Shoop::bool($result);
    }

    public function isSame($compare): ESBool
    {
        $isSub = is_subclass_of($compare, ESBaseType::class);
        $isNotSub = Shoop::bool($isSub)->toggle()->unfold();
        if ($isNotSub) {
            $compare = $this->instanceFromValue($compare);
        }
        return Shoop::bool($this->unfold() === $compare->unfold());
    }

    static public function valueisSubclass($value, string $className)
    {
        # code...
    }

    static public function valueisNotSubclass($value, string $className)
    {
        # code...
    }

    static public function valueIsClass($value, string $className)
    {
        # code...
    }

    static public function valueIsNotClass($value, string $className)
    {
        # code...
    }

    static public function valueIsArray($value)
    {
        return is_array($value) || (self::isShoop($value) && is_a($value, ESArray::class));
    }

    static public function valueIsNotArray($value)
    {
        return ! self::valueIsArray($value);
    }

    public function isArray()
    {
        return is_array($this->unfold());
    }

    public function isNotArray()
    {
        return ! $this->isArray();
    }

    final public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }

    protected function instanceFromValue($value)
    {
        // Get Shoop from PHP data type
        if ($value === null) {
            return null;

        } elseif (array_key_exists($this->typeForValue($value), Shoop::typeMap())) {
            $map = Shoop::typeMap();
            $class = $map[$this->typeForValue($value)];
            return $class::fold($value);

        }
        return $this;
    }

    final protected function sanitizeType($toSanitize, string $desiredPhpType, string $shoopClass)
    {
        if (is_a($toSanitize, $shoopClass)) {
            return $toSanitize;
        }

        $this->isDesiredTypeOrTriggerError($desiredPhpType, $toSanitize);

        return $shoopClass::fold($toSanitize);
    }

    private function typeForValue($value)
    {
        $type = gettype($value);
        if ($type === "integer") {
            $type = "int";
        }
        return $type;
    }

    private function isDesiredTypeOrTriggerError($desiredPhpType, $variable)
    {
        $sanitizeType = $this->typeForValue($variable);
        if ($sanitizeType !== $desiredPhpType) {
            list($_, $caller) = debug_backtrace(false);
            $this->invalidTypeError($desiredPhpType, $sanitizeType, $caller);
        }
    }

    private function invalidTypeError($desiredPhpType, $sanitizeType, $caller)
    {
        $className = $caller['class'];
        $functionName = $caller['function'];
        $myClass = static::class;
        trigger_error(
            "Argument 1 passed to {$functionName} in {$className} must be of type {$desiredPhpType} or an instance of {$myClass} received {$sanitizeType} instead",
            E_USER_ERROR
        );
    }

//-> Enumerable
    public function count()
    {
        return Shoop::int(count($this->enumerated()->unfold()));
    }

    public function countIsGreaterThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class)
            ->unfold();
        return $this->count()->isGreaterthan($value);
    }

    public function countIsNotGreaterThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isNotGreaterThan($value);
    }

    public function countIsLessThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isLessThan($value);
    }

    public function countIsNotLessThan($value)
    {
        $value = $this->sanitizeType($value, "int", ESInt::class, false)
            ->unfold();
        return $this->count()->isNotLessThan($value);
    }
}
