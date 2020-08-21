<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

// use Eightfold\Shoop\Shoop;

// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

// use Eightfold\Shoop\PipeFilters\MinusUsing\FromList;

class MinusUsing extends Filter
{
    private $callback;

    public function __construct(callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $filtered = ($this->callback === null)
                ? array_filter($using)
                : array_filter($using, $this->callback);

            return TypeAsArray::apply()->unfoldUsing($filtered);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using) or
            TypeIs::applyWith("object")->unfoldUsing($using)
        ) {

        }
    }
}
