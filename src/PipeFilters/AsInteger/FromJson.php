<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInteger;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsInteger;

class FromJson extends Filter
{
    public function __invoke(string $using): int
    {
        $isJson = Shoop::pipe($using, IsJson::apply())->unfold();
        return Shoop::pipe($using, AsObject::apply(), AsInteger::apply())
            ->unfold();
    }
}
