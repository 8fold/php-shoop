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

class AsDictionary extends Filter
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload, FromBool::apply())->unfold();

        } elseif (is_int($payload)) {
            return Shoop::pipe($payload, FromInt::apply())->unfold();

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload, FromObject::apply())->unfold();

        } elseif (is_array($payload)) {
            return (Shoop::pipe($payload, IsDictionary::apply())->unfold())
                ? $payload
                : Shoop::pipe($payload, FromArray::apply())->unfold();

        } elseif (is_string($payload)) {
            return (Shoop::pipe($payload, IsJson::apply())->unfold())
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : Shoop::pipe($payload, FromString::apply())->unfold();

        }
        return [];
    }
}
