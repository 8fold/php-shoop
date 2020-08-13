<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsObject;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $payload): object
    {
        $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
        return ($isJson) ? json_decode($payload) : new \stdClass;
    }
}
