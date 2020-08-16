<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use \stdClass;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullContent;
use Eightfold\Shoop\PipeFilters\AsTuple\FromDictionary;
use Eightfold\Shoop\PipeFilters\AsTuple\FromJson;
use Eightfold\Shoop\PipeFilters\AsTuple\FromObject;
use Eightfold\Shoop\PipeFilters\AsTuple\FromString;

class AsTuple extends Filter
{
    public function __invoke($using): object
    {
        if (IsTuple::apply()->unfoldUsing($using)) return $using;

        if (IsDictionary::apply()->unfoldUsing($using)) {
            return FromDictionary::apply()->unfoldUsing($using);

        } elseif (IsObject::apply()->unfoldUsing($using)) {
            return FromObject::apply()->unfoldUsing($using);

        } elseif (IsJson::apply()->unfoldUsing($using)) {
            return FromJson::apply()->unfoldUsing($using);

        } elseif (IsString::apply()->unfoldUsing($using)) {
            return FromString::apply()->unfoldUsing($using);

        } else {
            // IsBoolean
            // IsNumber
            // IsInteger
            // IsArray
            return Shoop::pipe($using,
                AsDictionary::apply(),
                AsTuple::apply()
            )->unfold();
        }
    }
}
