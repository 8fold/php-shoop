<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsInt\FromArray;
use Eightfold\Shoop\PipeFilters\AsInt\FromBool;
use Eightfold\Shoop\PipeFilters\AsInt\FromJson;
use Eightfold\Shoop\PipeFilters\AsInt\FromObject;
use Eightfold\Shoop\PipeFilters\AsInt\FromString;

class AsInt extends Filter
{
    public function __invoke($payload): int
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload, FromBool::apply())->unfold();

        } elseif (is_int($payload)) {
            return $payload;

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload, FromObject::apply())->unfold();

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, FromArray::apply())->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
            return ($isJson)
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : Shoop::pipe($payload, FromString::applyWith(...$this->args(true)))
                    ->unfold();

        }
        return 0;
    }
}
