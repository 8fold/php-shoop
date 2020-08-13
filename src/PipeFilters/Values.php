<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Values\FromArray;

class Values extends Filter
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            // ToArrayFromBoolean
        } elseif (is_int($payload)) {

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, FromArray::apply())->unfold();

        } elseif (is_string($payload)) {

        }
        return [];
    }
}
