<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullContent;
use Eightfold\Shoop\PipeFilters\AsArray\FromBool;
use Eightfold\Shoop\PipeFilters\AsArray\FromInt;
use Eightfold\Shoop\PipeFilters\AsArray\FromJson;
use Eightfold\Shoop\PipeFilters\AsArray\FromObject;
use Eightfold\Shoop\PipeFilters\AsArray\FromString;

class AsArray extends Filter
{
    public function __invoke($using): array
    {
        if (is_bool($using)) {
            return Shoop::pipe($using, FromBool::apply())->unfold();

        } elseif (is_int($using)) {
            return Shoop::pipe($using,
                FromInt::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_object($using)) {
            return Shoop::pipe($using, FromObject::apply())->unfold();

        } elseif (is_array($using)) {
            return Shoop::pipe($using, PullContent::apply())->unfold();

        } elseif (is_string($using)) {
            return (Shoop::pipe($using, IsJson::apply())->unfold())
                ? Shoop::pipe($using, FromJson::apply())->unfold()
                : Shoop::pipe($using, FromString::applyWith(...$this->args(true)))->unfold();

        }
        return [];
    }
}
