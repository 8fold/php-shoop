<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use \Closure;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Type;
use Eightfold\Shoop\Filter\IsEmpty;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;

class AsDictionary extends Filter
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
        return ($using)
            ? ["false" => false, "true" => true]
            : ["false" => true, "true" => false];
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): array
    {
        $array = AsArray::fromNumber($using);

        // TODO: make pattern a Filter - enhanced map able to include keys - ??
        //      see fromList
        $build = [];
        array_walk($array, function($value, $member) use (&$build) {
            $member = AsString::fromNumber($member);
            // $member = number_format($member, 1, ".", ","); // TODO: make Filter - ??
            $build[$member] = $value;
        });
        return $build;
    }

    static public function fromString(string $using): array
    {
        return (IsEmpty::fromString($using)) ? [] : ["content" => $using];
    }

    static public function fromList(array $using): array
    {
        // TODO: make pattern a Filter - enhanced map able to include keys - ??
        //      see fromList
        $build = [];
        array_walk($using, function($value, $member) use (&$build) {
            if (IsNumber::apply()->unfoldUsing($member)) {
                $member = number_format($member, 1, ".", ","); // TODO: make Filter - ??
            }

            $build[$member] = $value;
        });
        return $build;
    }

    // TODO: PHP 8 - string|object
    static public function fromTuple($using): array
    {
        if (IsJson::apply()->unfoldUsing($using)) {
            if (IsEmpty::fromJson($using)) {
                return [];
            }
            return  static::fromJson($using);

        }

        $properties = get_object_vars($using);

        $filtered = array_filter($properties,
            function($v, $k) {
                return $v !== null and ! is_a($v, Closure::class);
            },
            ARRAY_FILTER_USE_BOTH
        ); // TODO: Retain

        return $filtered;
    }

    static public function fromJson(string $using): array
    {
        $tuple = AsTuple::fromJson($using);
        return static::fromTuple($tuple);
    }

    static public function fromObject(object $using): array
    {
        if (is_a($using, Associable::class)) {
            return $using->efToDictionary();
        }
        return static::fromTuple($using);
    }
}
