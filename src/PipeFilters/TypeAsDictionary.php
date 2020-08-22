<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class TypeAsDictionary extends Filter
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
            return ($using)
                ? ["false" => false, "true" => true]
                : ["false" => true, "true" => false];

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $array = TypeAsArray::applyWith($this->start)->unfoldUsing($using);

            if (is_bool($this->includeEmpties)) {
                $this->includeEmpties = "i";
            }

            return TypeAsDictionary::applyWith($this->includeEmpties)
                ->unfoldUsing($array);

        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
            if (is_bool($this->includeEmpties)) {
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
}
