<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsBool extends Filter
{
    public function __invoke($payload): Bool
    {
        if (is_bool($payload)) {
            return $payload;

        } elseif (is_int($payload)) {
            return (bool) $payload;

        } elseif (is_object($payload)) {
            return Shoop::pipe($payload,
                AsDictionary::apply(),
                AsInt::apply(),
                IntIsNot::applyWith(0)
            )->unfold();

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload,
                AsInt::apply(),
                IntIsNot::apply(0)
            )->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($payload,
                    ToArrayFromJson::apply(),
                    ToIntegerFromArray::apply(),
                    IntegerIsNot::applyWith(0)
                )->unfold();
            }
        //     return Shoop::pipe($payload, AsArrayFromString::apply())
        //         ->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
