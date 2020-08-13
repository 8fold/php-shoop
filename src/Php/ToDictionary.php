<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToDictionary extends Bend
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
        //     // ToArrayFromBoolean
        } elseif (is_int($payload)) {
            return Shoop::pipeline($payload, ToDictionaryFromInteger::bend())
                ->unfold();

        // } elseif (is_object($payload)) {
        //     // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipeline($payload,
                ToDictionaryFromArray::bend()
            )->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipeline($payload, StringIsJson::bend())->unfold();
            if ($isJson) {
                // return Shoop::pipeline($payload,
                //     ToArrayFromJson::bend(),
                //     ToIntegerFromArray::bend(),
                //     IntegerIsNot::bendWith(0)
                // )->unfold();
            }
        //     return Shoop::pipeline($payload, ToArrayFromString::bend())
        //         ->unfold();
        }
        var_dump(__FILE__);
        die(var_dump($payload));
        // return [];
    }
}
