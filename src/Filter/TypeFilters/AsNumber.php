<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class AsNumber extends Filter
{
    public function __invoke($using)
    {
    }

    // TODO: PHP 8 -> int|float
    static public function fromBoolean(bool $using): int
    {
        return AsInteger::fromBoolean($using);
    }

    // TODO: PHP 8 - int|float -> int|float
    static public function fromNumber($using)
    {
        return (IsInteger::apply()->unfoldUsing($using))
            ? AsInteger::fromNumber($using)
            : (float) $using;
    }

    // TODO: PHP 8 -> int|float
    /**
     * If the string starts with a letter, 0 will be returned.
     *
     * If the string starts with a number, any characters following a numeric sequence are dropped. ex. 30he77o outputs 30
     *
     * If the string starts with a number and contains a period, a floating point number is returned, which may be an integer. ex. 30h.e77o outputs 30.0
     */
    static public function fromString(string $using)
    {
        if (strpos($using, ".") !== false) {
            return (float) $using;
        }
        return AsInteger::fromString($using);
    }

    static public function fromList(array $using): int
    {
        return AsInteger::fromList($using);
    }

    static public function fromTuple($using): int
    {
        return AsInteger::fromTuple($using);
    }

    static public function fromJson(string $using): int
    {
        return AsInteger::fromJson($using);
    }

    static public function fromObject(object $using): int
    {
        return AsInteger::fromObject($using);
    }
}
