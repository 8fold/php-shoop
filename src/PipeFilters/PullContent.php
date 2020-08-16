<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullContent\FromArray;

class PullContent extends Filter
{
    public function __invoke($using): array
    {
        if (is_bool($using)) {
            // ToArrayFromBoolean
        } elseif (is_int($using)) {

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            return Shoop::pipe($using, FromArray::apply())->unfold();

        } elseif (is_string($using)) {

        }
        return [];
    }
}