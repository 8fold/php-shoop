<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\IsEmpty;

use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;

class AsArray extends Filter
{
    private $start = 0; // divisor
    private $includeEmpties = true; // includeRemainder
    private $limit = PHP_INT_MAX;

    // TODO: PHP 8.0 - int|string
    public function __construct(
        $start = 0,
        bool $includeEmpties = true,
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
            return ($using) ? [false, true] : [true, false];

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $int = TypeAsInteger::apply()->unfoldUsing($this->start);
            return range($int, $using);

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using) or
            TypeIs::applyWith("tuple")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                TypeAsArray::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            return array_values($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
            if (TypeIs::applyWith("integer")->unfoldUsing($this->start)) {
                return str_split($using);

            } elseif (TypeIs::applyWith("string")->unfoldUsing($this->start)) {
                $array = explode($this->start, $using, $this->limit);
                $array = ($this->includeEmpties) ? $array : array_filter($array);
                return array_values($array);

            }

        } elseif (TypeIs::applyWith("arrayable")->unfoldUsing($using)) {
            $args = $this->args(true);
            if (count($args) === 0) {
                return $using->efToArray();

            }
            return $using->array(...$args);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (is_a($using, Arrayable::class)) {
                return $using->efToArray();
            }
            $dictionary = TypeAsDictionary::apply()->unfoldUsing($using);
            return TypeAsArray::apply()->unfoldUsing($dictionary);

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
