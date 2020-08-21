<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

// use \stdClass;

// use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;
// use Eightfold\Shoop\PipeFilters\TypeOf;

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
            return [$using];

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $int = TypeAsInteger::apply()->unfoldUsing($this->start);
            return range($int, $using);

        } elseif (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            return array_values($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            if (TypeIs::applyWith("integer")->unfoldUsing($this->start)) {
                return preg_split('//u', $using, -1, PREG_SPLIT_NO_EMPTY);

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
