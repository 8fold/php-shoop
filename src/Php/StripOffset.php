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
                unset($payload[$offset]);
                return $payload;
            }
            return false;

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
            }
            // TOOD: Not fully implemented
                return Shoop::pipe($payload,
                    AsArray::apply(),
                    StripOffset::applyWith($offset),
                    AsString::apply()
                )->unfold();
        }
        return [];
    }
}
