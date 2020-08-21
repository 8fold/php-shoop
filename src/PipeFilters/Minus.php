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

// use Eightfold\Shoop\PipeFilters\Minus\FromList;
// use Eightfold\Shoop\PipeFilters\Minus\FromBoolean;
// use Eightfold\Shoop\PipeFilters\Minus\FromNumber;
// use Eightfold\Shoop\PipeFilters\Minus\FromString;
// use Eightfold\Shoop\PipeFilters\Minus\FromTuple;
// use Eightfold\Shoop\PipeFilters\Minus\FromObject;
// use Eightfold\Shoop\PipeFilters\Minus\FromJson;

class Minus extends Filter
{
    // private $subtrahendsOrFromStart = [];
    // private $sameKey                = false;
    // private $charMask               = [" ", "\t", "\n", "\r", "\0", "\x0B"];

    // // TODO: PHP 8.0 - int|array|bool, bool, array
    // public function __construct(
    //     $subtrahendsOrFromStart = [], // int|array|bool
    //     bool $sameKeyOrFromEnd = false, // bool
    //     array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"] // array
    // )
    // {
    //     if (! is_array($subtrahends)) {
    //         $subtrahends = [$subtrahends];
    //     }
    //     $this->subtrahends = $subtrahends;
    //     $this->sameKey     = $sameKey;
    //     $this->charMask    = $charMask;
    // }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                Minus::applyWith($this->main),
                TypeAsBoolean::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $int = array_sum($this->main);
            return $using - $int;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $filtered = array_filter($using, function($v, $k) {
                return ! in_array($v, $this->main, true);
            }, ARRAY_FILTER_USE_BOTH);

            if (TypeIs::applyWith("dictionary")->unfoldUsing($filtered)) {
                return $filtered;

            }
            return TypeAsArray::apply()->unfoldUsing($filtered);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $this->fromString($using, ...$this->args(true));

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Minus::applyWith($this->main),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                Minus::applyWith($this->main)
            )->unfold();

        }
        // die("fell through");
        // if (IsNumber::apply()->unfoldUsing($using)) {
        //     return FromNumber::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);
        // }

        // if (IsBoolean::apply()->unfoldUsing($using)) {
        //     return FromBoolean::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);

        // } elseif (IsList::apply()->unfoldUsing($using)) {
        //     return FromList::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);

        // } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
        //     if (IsJson::apply()->unfoldUsing($using)) {
        //         return FromJson::applyWith(...$this->args(true))
        //             ->unfoldUsing($using);

        //     }
        //     return FromString::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);

        // } elseif (IsTuple::apply()->unfoldUsing($using)) {
        //     return FromTuple::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);

        // } elseif (IsObject::apply()->unfoldUsing($using)) {
        //     return FromObject::applyWith(...$this->args(true))
        //         ->unfoldUsing($using);

        // }
    }

    static private function fromString(
        string $using,
        bool $fromStart = true,
        bool $fromEnd   = true,
        array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"]
    ): string
    {
        $fromStartAndEnd = ($fromStart and $fromEnd) ? true : false;
        $all             = (! $fromStart and ! $fromEnd) ? true : false;

        if ($fromStartAndEnd) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return trim($using, $charMask);

        } elseif ($fromStart) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return ltrim($using, $charMask);

        } elseif ($fromEnd) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return rtrim($using, $charMask);

        } elseif ($all) {
            return str_replace($charMask, "", $using);

        }
    }
}
