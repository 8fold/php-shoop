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
                $value = Shoop::pipe($this->args, PullFirst::apply())->unfold();
                return $using[$offset] = $value;
            }
            return false;

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
            }
            $value = Shoop::pipe($this->args, PullFirst::apply())->unfold();
            $offset = Shoop::pipe($this->args, OffsetGet::applyWith(1))
                ->unfold();
            return Shoop::pipe($using,
                AsArray::apply(),
                OffsetSet::apply($value, $offset),
                AsString::apply()
            )->unfold();
        }
        return [];
    }
}
