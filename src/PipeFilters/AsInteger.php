<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsInteger\FromArray;
use Eightfold\Shoop\PipeFilters\AsInteger\FromBool;
use Eightfold\Shoop\PipeFilters\AsInteger\FromJson;
use Eightfold\Shoop\PipeFilters\AsInteger\FromObject;
use Eightfold\Shoop\PipeFilters\AsInteger\FromString;

class AsInteger extends Filter
{
    public function __invoke($using): int
    {
        if (is_bool($using)) {
            return Shoop::pipe($using, FromBool::apply())->unfold();

        } elseif (is_int($using)) {
            return $using;

        } elseif (is_object($using)) {
            return Shoop::pipe($using, FromObject::apply())->unfold();

        } elseif (is_array($using)) {
            return Shoop::pipe($using, FromArray::apply())->unfold();

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, IsJson::apply())->unfold();
            return ($isJson)
                ? Shoop::pipe($using, FromJson::apply())->unfold()
                : Shoop::pipe($using, FromString::applyWith(...$this->args(true)))
                    ->unfold();

        }
        return 0;
    }
}
