<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsJson;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\PipeFilters\AsJson;

class FromTuple extends Filter
{
    public function __invoke(object $using): string
    {
        return json_encode($using);
    }
}
