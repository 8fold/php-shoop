<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class EndsWithString extends Filter
{
    private $suffix = "";

    public function __construct(string $suffix = "")
    {
        $this->suffix = $suffix;
    }

    // TODO: PHP 8.0 array|string
    public function __invoke(string $payload): bool
    {
        // TODO: PHP 8.0 - str_ends_with()
        // TODO: Use pip - stringToInt()->intReversed()
        $length = Shoop::pipe($this->suffix, ToIntegerFromString::apply())
            ->unfold();
        return Shoop::pipe($payload,
            StringFromString::applyWith(-$length),
            EqualStrings::applyWith($this->suffix)
        )->unfold();
    }
}
