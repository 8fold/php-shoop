<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\IsEmpty;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $using): bool
    {
        if (! IsJson::apply()->unfoldUsing($using)) return false;

        return Shoop::pipe($using,
            AsObject::apply(),
            IsEmpty::apply()
        )->unfold();
    }
}
