<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Values;
use Eightfold\Shoop\PipeFilters\AsArray\FromBool;
use Eightfold\Shoop\PipeFilters\AsArray\FromInt;
use Eightfold\Shoop\PipeFilters\AsArray\FromJson;
use Eightfold\Shoop\PipeFilters\AsArray\FromObject;
use Eightfold\Shoop\PipeFilters\AsArray\FromString;

class AsArray extends Filter
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload, FromBool::apply())->unfold();

        } elseif (is_int($payload)) {
            return Shoop::pipe($payload,
                FromInt::applyWith(...$this->args(true))
            )->unfold();

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload, FromObject::apply())->unfold();

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, Values::apply())->unfold();

        } elseif (is_string($payload)) {
            return (Shoop::pipe($payload, IsJson::apply())->unfold())
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : Shoop::pipe($payload, FromString::applyWith(...$this->args(true)))->unfold();

        }
        return [];
    }
}
