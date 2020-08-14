<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use \stdClass;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\AsObject\FromArray;
use Eightfold\Shoop\PipeFilters\AsObject\FromBool;
use Eightfold\Shoop\PipeFilters\AsObject\FromDictionary;
use Eightfold\Shoop\PipeFilters\AsObject\FromInt;
use Eightfold\Shoop\PipeFilters\AsObject\FromJson;
use Eightfold\Shoop\PipeFilters\AsObject\FromString;

class AsObject extends Filter
{
    public function __invoke($using): object
    {
        if (is_bool($using)) {
            return Shoop::pipe($using, FromBool::apply())->unfold();

        } elseif (is_int($using)) {
            return Shoop::pipe($using,
                FromInt::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_object($using)) {
            return $using;

        } elseif (is_array($using)) {
            return (Shoop::pipe($using, IsDictionary::apply())->unfold())
                ? Shoop::pipe($using, FromDictionary::apply())->unfold()
                : Shoop::pipe($using, FromArray::apply())->unfold();

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, IsJson::apply())->unfold();
            return ($isJson)
                ? Shoop::pipe($using, FromJson::apply())->unfold()
                : Shoop::pipe($using, FromString::apply())->unfold();
        }
        return new stdClass;
    }
}
