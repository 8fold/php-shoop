<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

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
        $needles      = Shoop::pipeline($charMask, ToArrayFromString::bend())->unfold();
        $replacements = array_fill(0, count($needles), "");

        //TODO: ArrayToDictionary::bendWith($members);
        // $combined = array_combine($members, $keys);
        // TODO: MembersFromArray::bend();
        // TODO: MembersFromDictionary::bend();
        return str_replace($needles, $replacements, $payload);
    }
}
