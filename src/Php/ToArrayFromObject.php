<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class ToArrayFromObject extends Filter
{
    public function __invoke(object $payload): array
    {
        return Shoop::pipe($payload,
            ToDictionaryFromObject::apply(),
            ValuesFromArray::apply()
        )->unfold();
    }
}
