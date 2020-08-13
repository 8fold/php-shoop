<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsArray extends Filter
{
    public function __construct(...$args)
    {
        $this->args = $args;
    }

    public function __invoke($payload): array
    {
        if (is_bool($payload)) {
            // ToArrayFromBoolean
        } elseif (is_int($payload)) {
            $start = Shoop::pipe($this->args, First::apply(), AsInt::apply())
                ->unfold();
            return ($start > $int)
                ? range($payload, $start)
                : range($start, $payload);

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return Shoop::pipe($payload, ValuesFromArray::apply())->unfold();

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                return Shoop::pipe($payload,
                    AsObject::apply(),
                    AsArray::apply()
                )->unfold();
            }
            return Shoop::pipe($payload, AsArrayFromString::apply())
                ->unfold();
        }
        return [];
    }
}
