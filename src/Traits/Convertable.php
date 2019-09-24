<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait Convertable
{
    private function sanitizeType($toSanitize, string $desiredPhpType, string $shoopClass)
    {
        if (is_a($toSanitize, $shoopClass)) {
            return $toSanitize;
        }

        $this->isDesiredTypeOrTriggerError($desiredPhpType, $toSanitize);

        return $shoopClass::fold($toSanitize);
    }

    private function isDesiredTypeOrTriggerError($desiredPhpType, $variable)
    {
        $sanitizeType = Shoop::typeForValue($variable);
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
