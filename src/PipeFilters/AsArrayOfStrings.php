<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullContent;
use Eightfold\Shoop\PipeFilters\AsArrayOfStrings\FromArray;

class AsArrayOfStrings extends Filter
{
    public function __invoke($using): array
    {
        if (is_bool($using)) {
die("is bool");

        } elseif (is_int($using)) {
die("is int");

        } elseif (is_object($using)) {
die("is object");

        } elseif (is_array($using)) {
            return Shoop::pipe($using, FromArray::apply())->unfold();

        } elseif (is_string($using)) {
die("is string");

        }
        return [];
    }
}
