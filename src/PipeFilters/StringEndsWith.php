<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray\FromString as AsArrayFromString;

class StringEndsWith extends Filter
{
    private $suffix = "";

    public function __construct(string $suffix = "")
    {
        $this->suffix = $suffix;
    }

    // TODO: PHP 8.0 - str_ends_with()
    // TODO: PHP 8.0 array|string
    public function __invoke(string $using): bool
    {
        $length = AsInteger::apply()->unfoldUsing($this->suffix);

        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            PullRange::applyWith(-$length),
            AsString::apply(),
            Is::applyWith($this->suffix)
        )->unfold();
    }
}
