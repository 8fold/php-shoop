<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Type;
use Eightfold\Shoop\Filter\IsEmpty;

use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;

class AsArray extends Filter
{
    public function __invoke($using): array
    {
        if (Type::isBoolean()->unfoldUsing($using)) {
            return static::fromBoolean($using);

        } elseif (Type::isNumber()->unfoldUsing($using)) {
            return static::fromNumber($using);

        } elseif (Type::isString()->unfoldUsing($using)) {
            return static::fromString($using);

        } elseif (Type::isList()->unfoldUsing($using)) {
            return static::fromList($using);

        } elseif (Type::isTuple()->unfoldUsing($using)) {
            return static::fromTuple($using);

        } elseif (Type::isObject()->unfoldUsing($using)) {
            return static::fromObject($using);

        }
    }

    static public function fromBoolean(bool $using): array
    {
        $dictionary = AsDictionary::fromBoolean($using);
        return AsArray::fromList($dictionary);
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): array
    {
        return (array) $using;
    }

    static public function fromString(string $using): array
    {
        return (IsEmpty::fromString($using)) ? [] : str_split($using);
    }

    static public function fromList(array $using): array
    {
        return array_values($using);
    }

    // TODO: PHP 8 - string|object
    static public function fromTuple($using): array
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): array
    {
        $tuple = AsTuple::fromJson($using);
        return static::fromTuple($tuple);
    }

    static public function fromObject(object $using): array
    {
        return (is_a($using, Arrayable::class))
            ? $using->efToArray()
            : static::fromTuple($using);
    }
}
