<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;
use Eightfold\Shoop\PipeFilters\TypeOf;

class TypeAsJson extends Filter
{
    // private $targetType = "boolean";
    // private $secondary  = 0;
    // private $tertiary   = false;
    // private $quaternary = PHP_INT_MAX;
    // private $quinary    = "";

    // public function __construct(
    //     string $targetType = "boolean",
    //     $secondary         = 0, // TODO: PHP 8.0 - int|string
    //     bool $tertiary     = false,
    //     int $quaternary    = PHP_INT_MAX,
    //     string $quinary    = "i"
    // )
    // {
    //     $this->targetType = $targetType;
    //     $this->secondary  = $secondary;
    //     $this->tertiary   = $tertiary;
    //     $this->quaternary = $quaternary;
    //     $this->quinary    = $quinary;
    // }

    public function __invoke($using)
    {
        $tuple = TypeAsTuple::apply()->unfoldUsing($using);
        return json_encode($tuple);
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {

        }
    }
}
