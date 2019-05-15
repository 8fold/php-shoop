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

    final protected function sanitizeTypeOrTriggerError($sanitize, $desiredPhpType)
    {
        $sanitizeType = gettype($sanitize);
        $sanitizeTypeIsDesiredType = $sanitizeType === $desiredPhpType;
        if (!($sanitizeTypeIsDesiredType || is_a($sanitize, static::class))) {
            list($_, $caller) = debug_backtrace(false);
            $this->invalidTypeError($desiredPhpType, $sanitizeType, $caller);
        }

        $sanitize = ($sanitizeTypeIsDesiredType)
            ? static::wrap($sanitize)
            : $sanitize;
        return $sanitize;
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

//-> Randomizer
    final public function randomWithMethod(\Closure $method)
    {
        return $method($this);
    }
}
