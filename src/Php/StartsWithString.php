<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class StartsWithString extends Filter
{
    private $prefix = "";

    public function __construct(string $prefix = "")
    {
        $this->prefix = $prefix;
    }

    // TODO: PHP 8.0 - string|array
    public function __invoke(string $using): bool
    {
        // TODO: PHP 8.0 - str_starts_with()
        $length = Shoop::pipe($this->prefix, ToIntegerFromString::apply())
            ->unfold();
        return Shoop::pipe($using,
            StringFromString::applyWith(0, $length),
            EqualStrings::applyWith($this->prefix)
        )->unfold();
    }
}
