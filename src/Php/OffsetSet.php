<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class Plus extends Filter
{
    public function __construct(...$args)
    {
        $this->args = $args;
    }

    public function __invoke($payload)
    {
        if (is_bool($payload)) {
            // ToArrayFromBoolean
        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            $offset = Shoop::pipe($this->args, OffsetGet::applyWith(1))
                ->unfold();
            $exists = Shoop::pipe($payload, OffsetExists::applyWith($offset))
                ->unfold();
            if ($exists) {
                $value = Shoop::pipe($this->args, First::apply())->unfold();
                return $payload[$offset] = $value;
            }
            return false;

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
            }
            $value = Shoop::pipe($this->args, First::apply())->unfold();
            $offset = Shoop::pipe($this->args, OffsetGet::applyWith(1))
                ->unfold();
            return Shoop::pipe($payload,
                AsArray::apply(),
                OffsetSet::apply($value, $offset),
                AsString::apply()
            )->unfold();
        }
        return [];
    }
}
