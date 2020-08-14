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
    public function __invoke($payload): object
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload, FromBool::apply())->unfold();

        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, IntegerIsNot::applyWith(0))
            //     ->unfold();

        } elseif (is_object($payload)) {
            return $payload;

        } elseif (is_array($payload)) {
            return (Shoop::pipe($payload, IsDictionary::apply())->unfold())
                ? Shoop::pipe($payload, FromDictionary::apply())->unfold()
                : Shoop::pipe($payload, FromArray::apply())->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
            return ($isJson)
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : (object) ["string" => $payload];
        }
        return new stdClass;
    }
}
