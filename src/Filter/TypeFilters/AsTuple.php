<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Filter\Type;
use Eightfold\Shoop\Filter\Is;

class AsTuple extends Filter
{
    public function __invoke($using): stdClass
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

    static public function fromBoolean(bool $using): stdClass
    {
        $dictionary = AsDictionary::fromBoolean($using);
        return Astuple::fromList($dictionary);
    }

    // TODO: PHP 8.0 - int|float
    static public function fromNumber($using): stdClass
    {
        $dictionary = AsDictionary::fromNumber($using);
        return static::fromList($dictionary);
    }

    static public function fromString(string $using): stdClass
    {
        $dictionary = AsDictionary::fromString($using);
        return static::fromList($dictionary);
    }

    static public function fromList(array $using): stdClass
    {
        return (object) $using;
    }

    // TODO: PHP 8 - string|object
    static public function fromTuple($using): stdClass
    {
        $array = AsDictionary::fromTuple($using);
        return (object) $array;
    }

    static public function fromJson(string $using): stdClass
    {
        if (! IsJson::apply()->unfoldUsing($using)) {
            return (object) $using;

        }
        $tuple = json_decode($using);
        return static::fromTuple($tuple);
    }

    static public function fromObject(object $using): stdClass
    {
        return (is_a($using, Tupleable::class))
            ? $using->efToTuple()
            : static::fromTuple($using);
    }
}
