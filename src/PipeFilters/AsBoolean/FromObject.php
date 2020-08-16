<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBoolean;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsObject;
use Eightfold\Shoop\PipeFilters\AsNumber;
use Eightfold\Shoop\PipeFilters\AsBoolean;


class FromObject extends Filter
{
    public function __invoke(object $using): bool
    {
        if (IsObject::apply()->unfoldUsing($using)) {
            if (is_a($using, Falsifiable::class) or method_exists($using, "efToBool")) {
                return $using->efToBool();
            }
        }
        return Shoop::pipe($using, AsNumber::apply(), AsBoolean::apply())->unfold();
    }
}
