<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

class FromString extends Filter
{
    public function __invoke(string $using): array
    {
        return ["string" => $using];
    }
}
