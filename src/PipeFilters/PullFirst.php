<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullFirst\FromArray;
use Eightfold\Shoop\PipeFilters\PullFirst\FromInt;
use Eightfold\Shoop\PipeFilters\PullFirst\FromJson;
use Eightfold\Shoop\PipeFilters\PullFirst\FromObject;
use Eightfold\Shoop\PipeFilters\PullFirst\FromString;

use Eightfold\Shoop\PipeFilters\IsJson;

class PullFirst extends Filter
{
    public function __invoke($using)
    {
        if (is_bool($using)) {
            return [];

        } elseif (is_int($using)) {
            return Shoop::pipe($using,
                FromInt::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_object($using)) {
            return Shoop::pipe($using,
                FromObject::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_array($using)) {
            return Shoop::pipe($using,
                FromArray::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_string($using)) {
            if (Shoop::pipe($using, IsJson::apply())->unfold()) {
                return Shoop::pipe($using,
                    FromJson::applyWith(...$this->args())
                )->unfold();

            }

            return Shoop::pipe($using,
                FromString::applyWith(...$this->args(true))
            )->unfold();

        }
        return [];
    }
}
