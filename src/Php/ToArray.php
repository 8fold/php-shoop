<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToArray extends Bend
{
    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            // ToArrayFromBoolean
        } elseif (is_int($payload)) {
            return Shoop::pipeline($payload, ToArrayFromInteger::bend())->unfold();

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipeline($payload, ValuesFromArray::bend())->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipeline($payload, StringIsJson::bend())->unfold();
            if ($isJson) {
                return Shoop::pipeline($payload, ToArrayFromJson::bend())
                    ->unfold();
            }
            return Shoop::pipeline($payload, ToArrayFromString::bend())
                ->unfold();
        }
        return [];
    }
}
