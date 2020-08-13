<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsInt;

class FromJson extends Filter
{
    public function __invoke(string $payload): int
    {
        $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
        return Shoop::pipe($payload, AsObject::apply(), AsInt::apply())
            ->unfold();
    }
}
