<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsObject;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $using): object
    {
        $isJson = Shoop::pipe($using, IsJson::apply())->unfold();
        return ($isJson) ? json_decode($using) : new \stdClass;
    }
}
