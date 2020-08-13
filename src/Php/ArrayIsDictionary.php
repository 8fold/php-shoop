<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ArrayIsDictionary extends Bend
{
    public function __invoke(array $payload): bool
    {
        $firstMember = Shoop::pipeline($payload,
            MembersFromArray::bend(),
            FirstFromArray::bend()
        )->unfold();
        $members = array_keys($payload);
        $firstMember = array_shift($members);
        return is_string($firstMember) and ! is_int($firstMember);
    }
}
