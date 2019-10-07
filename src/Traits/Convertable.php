<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

trait Convertable
{
    private function sanitizeType($toSanitize, string $shoopType = "")
    {
        if (Type::isShooped($toSanitize)) {
            return $toSanitize;
        }

        if (Type::isPhp($toSanitize) && strlen($shoopType) === 0) {
            $desiredPhpType = Type::for($toSanitize);
            $shoopType = Type::phpToShoop($toSanitize);
        }

        if (isset($desiredPhpType)) {
            $this->isDesiredTypeOrTriggerError($desiredPhpType, $toSanitize);
        }

        return $shoopType::fold($toSanitize);
    }

    private function isDesiredTypeOrTriggerError($desiredPhpType, $variable)
    {
        $sanitizeType = Type::for($variable);
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
