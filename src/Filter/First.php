<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class First extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromList(array $array)
    {
        return $array[0];
    }
}
