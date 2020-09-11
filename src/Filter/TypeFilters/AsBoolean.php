<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

class AsBoolean extends Filter
{
    public function __invoke($using): bool
    {
    }

    static public function fromBoolean(bool $using): bool
    {
        return $using;
    }

    // TODO: PHP 8.0 - int|float
    static public function fromNumber($using): bool
    {
        return (bool) $using;
    }

    static public function fromString(string $using): bool
    {
        return (bool) $using;
    }

    static public function fromList(array $using): bool
    {
        return (bool) $using;
    }

    // TODO: PHP 8 - object|string
    static public function fromTuple($using): bool
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): bool
    {
        if (! IsJson::apply()->unfoldUsing($using)) {
            return false;
        }

        $tuple = AsTuple::fromJson($using);
        return static::fromTuple($tuple);
    }

    static public function fromObject(object $using): bool
    {
        if (is_a($using, Falsifiable::class)) {
            return $using->efToBoolean();
        }

        $tuple = AsTuple::fromObject($using);
        return static::fromTuple($tuple);
    }
}
