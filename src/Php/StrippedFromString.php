<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class StrippedFromString extends Bend
{
    private $fromEnd = true;
    private $fromStart = true;
    private $charMask = " \t\n\r\0\x0B";

    public function __construct(
        bool $fromEnd = true,
        bool $fromStart = true,
        string $charMask = " \t\n\r\0\x0B"
    )
    {
        $this->fromEnd = $fromEnd;
        $this->fromStart = $fromStart;
        $this->charMask = $charMask;
    }

    public function __invoke(string $payload): string
    {
        $string    = $payload;
        $fromEnd   = $this->fromEnd;
        $fromStart = $this->fromStart;
        $charMask  = $this->charMask;

        if ($this->fromStart and $this->fromEnd) {
            return trim($payload, $charMask);

        } elseif ($this->fromStart and ! $this->fromEnd) {
            return ltrim($payload, $charMask);

        } elseif (! $this->fromStart and $this->fromEnd) {
            return rtrim($payload, $charMask);

        }
        // TODO: Use pipeline
        $chars = Php::stringToArray($charMask);
        return str_replace($chars, "", $payload);
    }
}
