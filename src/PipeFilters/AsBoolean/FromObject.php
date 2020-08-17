<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBoolean;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsObject;
use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\AsBoolean;

use Eightfold\Shoop\PipeFilters\AsTuple;
use Eightfold\Shoop\PipeFilters\AsDictionary;

class FromObject extends Filter
{
    public function __invoke(object $using): bool
    {
        if (IsObject::apply()->unfoldUsing($using) and
            (is_a($using, Falsifiable::class) or method_exists($using, "efToBool"))
        ) {
            return $using->efToBool();

        }

        return Shoop::pipe($using, AsDictionary::apply(), AsBoolean::apply())
            ->unfold();
    }
}
