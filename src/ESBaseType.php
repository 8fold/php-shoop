<?php

namespace Eightfold\Shoop;

class ESBaseType
{
    protected $value;

    static public function wrap(...$args): ESBaseType
    {
        return new static(...$args);
    }

    public function __construct(...$args)
    {
        $this->value = $args[0];
    }

    public function unwrap()
    {
        return $this->value;
    }

    public function isEmpty(): ESBool
    {
        $result = empty($this->unwrap());
        return ESBool::wrap($result);
    }

    protected function instanceFromValue($value)
    {
        if ($this->hasTypeForValue($value)->toggle()->unwrap()) {
            return $this;
        }
        $class = $this->typeMap()->valueForKey($this->typeForValue($value));
        return ($this->typeForValue($value) === "array")
            ? $class::wrap(...$value)
            : $class::wrap($value);
    }

    private function hasTypeForValue($value): ESBool
    {
        if ($value === null) {
            return Shoop::bool(false);
        }
        return $this->typeMap()->hasKey($this->typeForValue($value));
    }

    private function typeForValue($value)
    {
        return gettype($value);
    }

    private function typeMap(): ESDictionary
    {
        return Shoop::dictionary(
            "boolean", ESBool::class,
            "integer", ESInt::class,
            "string", ESString::class,
            "array", ESArray::class,
            //"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
            // "object"
            // "resource"
            // "resource (closed)" as of PHP 7.2.0
            "NULL", null
            // "unknown type"
        );
    }

    final protected function sanitizeTypeOrTriggerError(
        $varToSanitize,
        $desiredPhpType,
        $class = null,
        $multipleArgs = false)
    {
        $class = ($class === null)
            ? static::class
            : $class;

        if (is_a($varToSanitize, $class)) {
            return $varToSanitize;
        }

        $this->isDesiredTypeOrTriggerError($desiredPhpType, $varToSanitize);

        return ($multipleArgs)
            ? $class::wrap(...$varToSanitize)
            : $class::wrap($varToSanitize);
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

//-> Comparison
    public function isSameAs($compare): ESBool
    {
        return Shoop::bool($this->unwrap() === $compare->unwrap());
    }

    final public function isDifferentThan(ESBaseType $compare): ESBool
    {
        return $this->isNot($compare);
    }

    final public function isNot(ESBaseType $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }
}
