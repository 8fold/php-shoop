<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson;

class FromTuple extends Filter
{
    public function __invoke(object $using): string
    {
        return json_encode($using);
    }
}
