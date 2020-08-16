<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsTuple;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $using): object
    {
        if (! IsJson::apply()->unfoldUsing($using)) return new \stdClass;

        return json_decode($using);
    }
}
