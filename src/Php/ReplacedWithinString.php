<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class StrippedWithinString extends Bend
{
    private $replacements = [];

    public function __construct(array $replacements = [])
    {
        $this->replacements = $replacements;
    }

    public function __invoke(string $payload): string
    {
        $members = Shoop::pipeline($payload, MembersFromArray::bend())->unfold();
        $values  = Shoop::pipeline($payload, ValuesFromArray::bend())->unfold();
        return str_replace($members, $values, $payload);

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
        // $chars = Shoop::pipeline($charMask, ToArrayFromString::bend())->unfold();
    }
}
