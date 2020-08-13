<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class AsInt extends Filter
{
    public function __invoke($payload): int
    {
        if (is_bool($payload)) {
            return (int) $payload;

        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, IntegerIsNot::applyWith(0))
            //     ->unfold();

        // } elseif (is_object($payload)) {
        //     // ToArrayFromObject

        } elseif (is_array($payload)) {
            return count($payload);

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($payload,
                    ToArrayFromJson::apply(),
                    ToIntegerFromArray::apply()
                )->unfold();
            }
            return Shoop::pipe($payload, ToIntegerFromString::apply())
                ->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
