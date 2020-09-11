<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class Last extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromList(array $array)
    {
        $array = Reversed::fromList($array);
        // $array = array_reverse($array); // TODO: Reversed
        return First::fromList($array);
    }
}
