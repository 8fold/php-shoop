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

    public function __invoke(string $using): string
    {
        $members = Shoop::pipe($using, MembersFromArray::apply())->unfold();
        $values  = Shoop::pipe($using, ValuesFromArray::apply())->unfold();
        return ($casesensitive)
            ? str_replace($members, $values, $using)
            : str_ireplace($members, $values, $using);

        // $string    = $using;
        // $fromEnd   = $this->fromEnd;
        // $fromStart = $this->fromStart;
        // $charMask  = $this->charMask;

        // if ($this->fromStart and $this->fromEnd) {
        //     return trim($using, $charMask);

        // } elseif ($this->fromStart and ! $this->fromEnd) {
        //     return ltrim($using, $charMask);

        // } elseif (! $this->fromStart and $this->fromEnd) {
        //     return rtrim($using, $charMask);

        // }
        // $chars = Shoop::pipe($charMask, AsArrayFromString::apply())->unfold();
    }
}
