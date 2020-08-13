<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsInt;

class FromObject extends Filter
{
    public function __invoke(object $payload): int
    {
        return Shoop::pipe($payload,
            AsDictionary::apply(),
            AsInt::apply()
        )->unfold();

    }
}
