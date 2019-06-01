<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

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

    protected function baseTypeForValue($value)
    {
        $typeMap = [
            "boolean" => ESBool::class,
            "integer" => ESInt::class,
            "string"  => ESString::class,
            "array"   => ESArray::class
            //"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
            // "object"
            // "resource"
            // "resource (closed)" as of PHP 7.2.0
            // "NULL"
            // "unknown type"
        ];

        $type = gettype($value);
        if (array_key_exists($type, $typeMap) && $value !== null) {
            $class = $typeMap[$type];
            return $class::wrap($value);
        }
        return $this;
    }

    final protected function sanitizeTypeOrTriggerError($varToSanitize, $desiredPhpType, $class = null)
    {
        $class = ($class === null)
            ? static::class
            : $class;

        if (is_a($varToSanitize, $class)) {
            return $varToSanitize;
        }

        $sanitizeType = gettype($varToSanitize);
        if ($sanitizeType !== $desiredPhpType) {
            list($_, $caller) = debug_backtrace(false);
            $this->invalidTypeError($desiredPhpType, $sanitizeType, $caller);
        }

        return $class::wrap($varToSanitize);
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
    final public function isSameAs(ESBaseType $compare): ESBool
    {
        $result = $this->unwrap() === $compare->unwrap();
        return ESBool::wrap($result);
    }

    final public function isDifferentThan(ESBaseType $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }

    final public function isNot(ESBaseType $compare): ESBool
    {
        return $this->isDifferentThan($compare);
    }

//-> Randomizer
    final public function randomWithMethod(\Closure $method)
    {
        return $method($this);
    }
}
