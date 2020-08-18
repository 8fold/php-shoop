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

use Eightfold\Shoop\PipeFilters\At\FromNumber;
use Eightfold\Shoop\PipeFilters\At\FromList;
use Eightfold\Shoop\PipeFilters\At\FromString;
use Eightfold\Shoop\PipeFilters\At\FromTuple;
use Eightfold\Shoop\PipeFilters\At\FromJson;

class At extends Filter
{
    public function __invoke($using)
    {
        if (IsList::apply()->unfoldUsing($using)) {
            return FromList::applyWith(...$this->args(true))
                ->unfoldUsing($using);
        }

        if (IsNumber::apply()->unfoldUsing($using)) {
            return FromNumber::applyWith($this->args(true))
                ->unfoldUsing($using);

        } elseif (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::applyWith($this->main)
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
            return FromObject::applyWith($this->main)
                ->unfoldUsing($using);

        }
    }
}
