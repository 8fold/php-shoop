<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\AsObject\FromJson;

class AsObject extends Filter
{
    public function __invoke($payload): object
    {
        if (is_bool($payload)) {
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                AsObject::apply()
            )->unfold();

        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, IntegerIsNot::applyWith(0))
            //     ->unfold();

        // } elseif (is_object($payload)) {
        //     // ToArrayFromObject

        } elseif (is_array($payload)) {
            $isDict = Shoop::pipe($payload, IsDictionary::apply())->unfold();
            if ($isDict) {
                return (object) $payload;
            }
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                AsObject::apply()
            )->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
            return ($isJson)
                ? Shoop::pipe($payload, FromJson::apply())->unfold()
                : (object) ["string" => $payload];
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
