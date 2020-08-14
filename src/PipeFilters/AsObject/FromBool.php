<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsObject;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\AsObject;

class FromBool extends Filter
{
    public function __invoke(bool $payload): object
    {
        return Shoop::pipe($payload,
            AsDictionary::apply(),
            AsObject::apply()
        )->unfold();
    }
}
