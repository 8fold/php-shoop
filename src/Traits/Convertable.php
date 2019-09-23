<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait Convertable
{
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
}
