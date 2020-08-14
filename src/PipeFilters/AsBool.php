<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsBool\FromArray;
use Eightfold\Shoop\PipeFilters\AsBool\FromInt;
use Eightfold\Shoop\PipeFilters\AsBool\FromJson;
use Eightfold\Shoop\PipeFilters\AsBool\FromObject;
use Eightfold\Shoop\PipeFilters\AsBool\FromString;
use Eightfold\Shoop\PipeFilters\IsJson;

class AsBool extends Filter
{
    public function __invoke($payload): Bool
    {
        if (is_bool($payload)) {
            return $payload;

        } elseif (is_int($payload)) {
            return Shoop::pipe($payload, FromInt::apply())->unfold();

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload, FromObject::apply())->unfold();

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, FromArray::apply())->unfold();

        } elseif (is_string($payload)) {
            return (Shoop::pipe($payload, IsJson::apply())->unfold())
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : Shoop::pipe($payload, FromString::apply())->unfold();

        }
        return false;
    }
}
