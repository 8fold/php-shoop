<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

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
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            return ($isJson)
                ? json_decode($payload)
                : (object) ["string" => $payload];
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
