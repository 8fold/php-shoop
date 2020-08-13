<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToObject extends Bend
{
    public function __invoke($payload): object
    {
        if (is_bool($payload)) {
            return Shoop::pipeline($payload,
                ToDictionaryFromBoolean::bend(),
                ToObjectFromArray::bend()
            )->unfold();

        } elseif (is_int($payload)) {
            // return Shoop::pipeline($payload, IntegerIsNot::bendWith(0))
            //     ->unfold();

        // } elseif (is_object($payload)) {
        //     // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipeline($payload, ToObjectFromArray::bend())
                ->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipeline($payload, StringIsJson::bend())->unfold();
            if ($isJson) {
                return Shoop::pipeline($payload,
                    ToObjectFromJson::bend()
                )->unfold();
            }
        //     return Shoop::pipeline($payload, ToArrayFromString::bend())
        //         ->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
