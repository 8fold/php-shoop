<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $using): bool
    {
        if (! IsJson::apply()->unfoldUsing($using)) return false;

        return $using !== '{}';
    }
}
