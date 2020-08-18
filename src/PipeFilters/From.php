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

use Eightfold\Shoop\PipeFilters\From\FromList;
use Eightfold\Shoop\PipeFilters\From\FromBoolean;
use Eightfold\Shoop\PipeFilters\From\FromNumber;
use Eightfold\Shoop\PipeFilters\From\FromString;
use Eightfold\Shoop\PipeFilters\From\FromTuple;
use Eightfold\Shoop\PipeFilters\From\FromObject;
use Eightfold\Shoop\PipeFilters\From\FromJson;

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
        if (IsList::apply()->unfoldUsing($using)) {
            return FromList::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        }

        if (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        } elseif (IsNumber::apply()->unfoldUsing($using)) {
            return FromNumber::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
            if (IsJson::apply()->unfoldUsing($using)) {
                return FromJson::applyWith($this->start, $this->length)
                    ->unfoldUsing($using);

            }
            return FromString::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        } elseif (IsTuple::apply()->unfoldUsing($using)) {
            return FromTuple::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            return FromObject::applyWith($this->start, $this->length)
                ->unfoldUsing($using);

        }
    }
}
