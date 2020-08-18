<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

// TODO: rename SubtractAt(...)
class Plus extends Filter
{
    public function __construct(...$args)
    {
        $this->args = $args;
    }

    public function __invoke($using)
    {
        if (is_bool($using)) {
            // ToArrayFromBoolean
        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            $offset = Shoop::pipe($this->args, OffsetGet::applyWith(1))
                ->unfold();
            $exists = Shoop::pipe($using, OffsetExists::applyWith($offset))
                ->unfold();
            if ($exists) {
                unset($using[$offset]);
                return $using;
            }
            return false;

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
            }
            // TOOD: Not fully implemented
                return Shoop::pipe($using,
                    AsArray::apply(),
                    StripOffset::applyWith($offset),
                    AsString::apply()
                )->unfold();
        }
        return [];
    }
}
