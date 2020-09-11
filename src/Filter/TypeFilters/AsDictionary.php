<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use \Closure;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\IsEmpty;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;

class AsDictionary extends Filter
{
    private $start = 0;
    private $includeEmpties = true;
    private $limit = PHP_INT_MAX;

    // TODO: PHP 8.0 - int|string, bool|string
    public function __construct(
        $start = 0,
        $includeEmpties = true,
        int $limit = PHP_INT_MAX
    )
    {
        $this->start = $start;
        $this->includeEmpties = $includeEmpties;
        $this->limit = $limit;
    }

    public function __invoke($using): array
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {


        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsArray::applyWith($this->start),
                TypeAsDictionary::applyWith(0, $this->includeEmpties)
            )->unfold();

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("array")->unfoldUsing($using)) {
                if (! is_string($this->includeEmpties)) {
                    $this->includeEmpties = "i";
                }

                $build = [];
                foreach ($using as $key => $value) {
                    if (is_int($key)) {
                        $key = $this->includeEmpties . $key;
                    }
                    $build[$key] = $value;
                }
                return $build;

            } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                return $using;

            } else {
                return [];

            }

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return ["content" => $using];

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                TypeAsDictionary::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            return (array) $using;

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            $tuple = TypeAsTuple::apply()->unfoldUsing($using);
            return TypeAsDictionary::apply()->unfoldUsing($tuple);

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
