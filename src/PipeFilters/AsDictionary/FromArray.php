<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsDictionary;

class FromArray extends Filter
{
    public function __invoke(array $payload): array
    {
        $isDict = Shoop::pipe($payload, IsDictionary::apply())->unfold();
        if ($isDict) {
            return $payload;
        }
        // TODO: test performance comparison to alternatives to foreach,
        //      hypothesis is that foreach is the fastest.
        $array = [];
        foreach ($payload as $member => $value) {
            $member = "i". $member;
            $array[$member] = $value;
        }
        return $array;
    }
}
