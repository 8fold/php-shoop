<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;
use Eightfold\Shoop\PipeFilters\TypeOf;

class TypeAsTuple extends Filter
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

    public function __invoke($using): object
    {
        if (TypeIs::applyWith("tuple")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $using;
        }

        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            $dictionary = TypeAsDictionary::apply()->unfoldUsing($using);
            return TypeAsTuple::apply()->unfoldUsing($dictionary);

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $dictionary = TypeAsDictionary::applyWith(
                $this->start,
                $this->includeEmpties,
                $this->limit
            )->unfoldUsing($using);
            return TypeAsTuple::apply()->unfoldUsing($dictionary);

        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
            if (is_bool($this->includeEmpties)) {
                $this->includeEmpties = "i";
            }

            $dictionary = TypeAsDictionary::applyWith(
                $this->includeEmpties
            )->unfoldUsing($using);

            return TypeAsTuple::apply()->unfoldUsing($dictionary);

        } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
            return (object) $using;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return (object) TypeAsDictionary::apply()->unfoldUsing($using);

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            return json_decode($using);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            $properties = get_object_vars($using);

            $filtered = array_filter($properties,
                function($v, $k) {
                    return $v !== null and ! is_a($v, Closure::class);
                },
                ARRAY_FILTER_USE_BOTH
            );

            $tuple = (object) $filtered;
            return $tuple;

        }
    }
}
