<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait Convertable
{
    private function sanitizeType($toSanitize, string $shoopType = "")
    {
        if (Shoop::valueIsShooped($toSanitize)) {
            return $toSanitize;
        }

        if (Shoop::valueIsPhpType($toSanitize) && strlen($shoopType) === 0) {
            $desiredPhpType = Shoop::phpTypeForValue($toSanitize);
            $shoopType = Shoop::shoopTypeForValue($toSanitize);
        }

        if (isset($desiredPhpType)) {
            $this->isDesiredTypeOrTriggerError($desiredPhpType, $toSanitize);
        }

        return $shoopType::fold($toSanitize);
    }

    private function isDesiredTypeOrTriggerError($desiredPhpType, $variable)
    {
        $sanitizeType = Shoop::phpTypeForValue($variable);
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
