<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class TypeAsArray extends Filter
{
    private $start = 0;
    private $includeEmpties = true;
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

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            $dictionary = TypeAsDictionary::apply()->unfoldUsing($using);
            return TypeAsArray::apply()->unfoldUsing($dictionary);

        }
    }
}
