<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class FirstFromArray extends Filter
{
    // TODO: Test using this for string starts with
    public function __invoke(array $using)
    {
        return array_shift($using);
    }
}
