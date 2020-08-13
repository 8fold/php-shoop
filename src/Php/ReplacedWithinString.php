<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class StrippedWithinString extends Filter
{
    private $replacements = [];
    private $casesensitive = true;

    public function __construct(
        array $replacements = [],
        bool $casesensitive = true
    )
    {
        $this->replacements = $replacements;
        $this->casesensitive = $casesensitive;
    }

    public function __invoke(string $payload): string
    {
        $members = Shoop::pipe($payload, MembersFromArray::apply())->unfold();
        $values  = Shoop::pipe($payload, ValuesFromArray::apply())->unfold();
        return ($casesensitive)
            ? str_replace($members, $values, $payload)
            : str_ireplace($members, $values, $payload);

        // $string    = $payload;
        // $fromEnd   = $this->fromEnd;
        // $fromStart = $this->fromStart;
        // $charMask  = $this->charMask;

        // if ($this->fromStart and $this->fromEnd) {
        //     return trim($payload, $charMask);

        // } elseif ($this->fromStart and ! $this->fromEnd) {
        //     return ltrim($payload, $charMask);

        // } elseif (! $this->fromStart and $this->fromEnd) {
        //     return rtrim($payload, $charMask);

        // }
        // $chars = Shoop::pipe($charMask, AsArrayFromString::apply())->unfold();
    }
}
