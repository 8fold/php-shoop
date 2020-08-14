<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBool;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsInteger;
use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\IsNot;

class FromJson extends Filter
{
    public function __invoke(string $payload): bool
    {
        $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
        if (! $isJson) { return false; }

        return Shoop::pipe($payload,
            AsObject::apply(),
            AsInteger::apply(),
            IsNot::applyWith(0)
        )->unfold();
    }
}
