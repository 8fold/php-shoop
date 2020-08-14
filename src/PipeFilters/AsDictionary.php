<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Reverse;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromArray;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromBool;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromInt;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromJson;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromObject;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromString;

class AsDictionary extends Filter
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
            return (Shoop::pipe($using, IsDictionary::apply())->unfold())
                ? $using
                : Shoop::pipe($using, FromArray::apply())->unfold();

        } elseif (is_string($using)) {
            return (Shoop::pipe($using, IsJson::apply())->unfold())
                ? Shoop::pipe($using, FromJson::apply())->unfold()
                : Shoop::pipe($using, FromString::apply())->unfold();

        }
        return [];
    }
}
