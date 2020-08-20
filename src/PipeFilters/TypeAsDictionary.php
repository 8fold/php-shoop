<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

// use \stdClass;

// use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;
// use Eightfold\Shoop\PipeFilters\TypeOf;

class TypeAsDictionary extends Filter
{
    private $start = 0;
    private $includeEmpties = true;
    private $limit = PHP_INT_MAX;
    private $prefixForString = "i";

    // TODO: PHP 8.0 - int|string, bool|string
    public function __construct(
        $start = 0,
        $includeEmpties = true,
        int $limit = PHP_INT_MAX,
        string $prefixForString = "i"
    )
    {
        $this->start = $start;
        $this->includeEmpties = $includeEmpties;
        $this->limit = $limit;
        $this->prefixForString = $prefixForString;
    }

    public function __invoke($using): array
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return ($using)
                ? ["true" => true, "false" => false]
                : ["true" => false, "false" => true];

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $array = TypeAsArray::applyWith($this->start)->unfoldUsing($using);

            if (is_bool($this->includeEmpties)) {
                $this->includeEmpties = "i";
            }

            return TypeAsDictionary::applyWith($this->includeEmpties)
                ->unfoldUsing($array);

        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
            $build = [];
            foreach ($using as $key => $value) {
                if (is_int($key)) {
                    $key = $this->start . $key;
                }
                $build[$key] = $value;
            }
            return $build;

        } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
            return $using;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            $array = TypeAsArray::applyWith($this->start, $using, $this->limit)
                ->unfoldUsing($using);
            $dictionary = TypeAsDictionary::applyWith($this->prefixForString)
                ->unfoldUsing($array);
            return $dictionary;

        }
    }
}
