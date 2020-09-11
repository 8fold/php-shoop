<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\FilterContracts\Interfaces\Countable;

class AsInteger extends Filter
{
    public function __invoke($using)
    {
    }

    // TODO: PHP 8 -> int|float
    static public function fromBoolean(bool $using): int
    {
        return (int) $using;
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): int
    {
        return (int) round($using); // TODO: Round filter
    }

    /**
     * If the string starts with a letter, 0 will be returned.
     *
     * If the string starts with a number, any characters following a numeric sequence are dropped. ex. 30he77o outputs 30
     */
    static public function fromString(string $using): int
    {
        return (int) $using;
    }

    static public function fromList(array $using): int
    {
        return (int) $using;
    }

    static public function fromTuple($using): int
    {
        if (! IsTuple::apply()->unfoldUsing($using)) {
            return 0;

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            $using = static::fromObject($using);

        } elseif (IsJson::apply()->unfoldUsing($using)) {
            $using = AsTuple::fromJson($using);

        }

        $boolean = AsBoolean::fromTuple($using);
        return static::fromBoolean($boolean);
    }

    static public function fromJson(string $using): int
    {
        return static::fromTuple($using);
    }

    static public function fromObject(object $using): int
    {
        if (is_a($using, Countable::class)) {
            return $using->efToInteger();
        }
        return static::fromTuple($using);
    }
}
