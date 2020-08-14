<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsDictionary;
use Eightfold\Shoop\PipeFilters\IsJson;

class FromJson extends Filter
{
    public function __invoke(string $payload): array
    {
        $isJson = Shoop::pipe($payload, IsJson::apply())->unfold();
        if ($isJson) {
            return Shoop::pipe($payload,
                AsObject::apply(),
                AsDictionary::apply()
            )->unfold();

        }
        return [];
    }
}
