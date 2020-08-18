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

use Eightfold\Shoop\PipeFilters\Reversed\FromList;
use Eightfold\Shoop\PipeFilters\Reversed\FromBoolean;
use Eightfold\Shoop\PipeFilters\Reversed\FromNumber;
use Eightfold\Shoop\PipeFilters\Reversed\FromString;
use Eightfold\Shoop\PipeFilters\Reversed\FromTuple;
use Eightfold\Shoop\PipeFilters\Reversed\FromObject;
use Eightfold\Shoop\PipeFilters\Reversed\FromJson;

class Reversed extends Filter
{
    public function __invoke($using)
    {
        if (IsList::apply()->unfoldUsing($using)) {
            return FromList::apply()->unfoldUsing($using);

        }

        if (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::apply()->unfoldUsing($using);

        } elseif (IsNumber::apply()->unfoldUsing($using)) {
            return FromNumber::apply()->unfoldUsing($using);

        } elseif (IsString::applyWith(true)->unfoldUsing($using)) {
            if (IsJson::apply()->unfoldUsing($using)) {
                return FromJson::apply()->unfoldUsing($using);

            }
            return FromString::apply()->unfoldUsing($using);

        } elseif (IsTuple::apply()->unfoldUsing($using)) {
            return FromTuple::apply()->unfoldUsing($using);

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            return FromObject::apply()->unfoldUsing($using);

        }
        die("fell through");
        if (is_bool($using)) {
            return ! $using;

        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            return array_reverse($using, $this->preserveMembers);

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return Shoop::pipe($using,
                AsArray::apply(),
                Reversed::apply(),
                AsString::apply()
            )->unfold();

        }
        return [];
    }
}
