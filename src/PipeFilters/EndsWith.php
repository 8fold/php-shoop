<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\From\FromList as SpanFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromString as AsIntegerFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class EndsWith extends Filter
{
    private $suffix = "";

    public function __construct(string $suffix = "")
    {
        $this->suffix = $suffix;
    }

    // TODO: PHP 8.0 - str_ends_with()
    // TODO: PHP 8.0 array|string
    public function __invoke(string $using): bool
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            $array = TypeAs::applyWith("array")->unfoldUsing($using);
            $span  = From::applyWith(
                0,
                TypeAs::applyWith("integer")->unfoldUsing($array)
            )->unfoldUsing($array);
            var_dump($span);
            die("string");

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        }
    }
}
