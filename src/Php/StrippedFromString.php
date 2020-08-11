<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

class StrippedFromString
{
    public function __invoke(array $payload): string
    {
        $string    = $payload["string"];
        $fromEnd   = $payload["fromEnd"];
        $fromStart = $payload["fromStart"];
        $charMask  = $payload["charsMask"];

        if ($fromStart and $fromEnd) {
            return trim($string, $charMask);

        } elseif ($fromStart and ! $fromEnd) {
            return ltrim($string, $charMask);

        } elseif (! $fromStart and $fromEnd) {
            return rtrim($string, $charMask);

        }
        return str_replace(Php::stringToArray($charMask), "", $string);
    }
}
