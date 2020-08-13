<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsDictionary extends Filter
{
    public function __invoke(array $payload): bool
    {
        $firstMember = Shoop::pipe($payload,
            MembersFromArray::apply(),
            FirstFromArray::apply()
        )->unfold();
        $members = array_keys($payload);
        $firstMember = array_shift($members);
        return is_string($firstMember) and ! is_int($firstMember);
    }
}
