<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
// use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

// use Eightfold\Shoop\PipeFilters\From\FromList;
// use Eightfold\Shoop\PipeFilters\From\FromBoolean;
// use Eightfold\Shoop\PipeFilters\From\FromNumber;
// use Eightfold\Shoop\PipeFilters\From\FromString;
// use Eightfold\Shoop\PipeFilters\From\FromTuple;
// use Eightfold\Shoop\PipeFilters\From\FromObject;
// use Eightfold\Shoop\PipeFilters\From\FromJson;

// TODO: rename to "From(start, length, fromEnd)"
class From extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    // TODO: Consider adding argument of "fromEnd = false" or a method to avoid
    //      users needing to put in PHP_INT_MAX
    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            $list = TypeAs::applyWith("array")->unfoldUsing($using);
            $list = From::applyWith($this->start, $this->length)
                ->unfoldUsing($list);
            return TypeAs::applyWith("string")->unfoldUsing($list);

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $preserveKeys = true;
            if (TypeIs::applyWith("array")->unfoldUsing($using)) {
                $preserveKeys = false;

            }
            return array_slice($using, $this->start, $this->length, $preserveKeys);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            $dictionary = TypeAs::applyWith("dictionary")->unfoldUsing($using);
            $dictionary = From::applyWith($this->start, $this->length)
                ->unfoldUsing($dictionary);

            return TypeAs::applyWith("json")->unfoldUsing($dictionary);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        }
        // if (IsList::apply()->unfoldUsing($using)) {
        //     return FromList::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // }

        // if (IsBoolean::apply()->unfoldUsing($using)) {
        //     return FromBoolean::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // } elseif (IsNumber::apply()->unfoldUsing($using)) {
        //     return FromNumber::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
        //     if (IsJson::apply()->unfoldUsing($using)) {
        //         return FromJson::applyWith($this->start, $this->length)
        //             ->unfoldUsing($using);

        //     }
        //     return FromString::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // } elseif (IsTuple::apply()->unfoldUsing($using)) {
        //     return FromTuple::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // } elseif (IsObject::apply()->unfoldUsing($using)) {
        //     return FromObject::applyWith($this->start, $this->length)
        //         ->unfoldUsing($using);

        // }
    }
}
