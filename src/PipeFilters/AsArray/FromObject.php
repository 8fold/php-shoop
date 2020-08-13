<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsArray;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsArray;

class FromObject extends Filter
{
    public function __invoke(object $payload): array
    {
        return Shoop::pipe($payload, AsDictionary::apply(), AsArray::apply())
            ->unfold();
    }
}
