<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

use Eightfold\Shoop\PipeFilters\Minus\FromList;
use Eightfold\Shoop\PipeFilters\Minus\FromBoolean;
use Eightfold\Shoop\PipeFilters\Minus\FromNumber;
use Eightfold\Shoop\PipeFilters\Minus\FromString;
use Eightfold\Shoop\PipeFilters\Minus\FromTuple;
use Eightfold\Shoop\PipeFilters\Minus\FromObject;
use Eightfold\Shoop\PipeFilters\Minus\FromJson;

// TODO: rename Subtract
class Minus extends Filter
{
    public function __invoke($using)
    {
        if (IsNumber::apply()->unfoldUsing($using)) {
            return FromNumber::applyWith(...$this->args(true))
                ->unfoldUsing($using);
        }

        if (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        } elseif (IsList::apply()->unfoldUsing($using)) {
            return FromList::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
            if (IsJson::apply()->unfoldUsing($using)) {
                return FromJson::applyWith(...$this->args(true))
                    ->unfoldUsing($using);

            }
            return FromString::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        } elseif (IsTuple::apply()->unfoldUsing($using)) {
            return FromTuple::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            return FromObject::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        }
    }
}
