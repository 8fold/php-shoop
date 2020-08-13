<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToDictionaryFromArray extends Bend
{
    public function __invoke(array $payload): array
    {
        $array = [];
        foreach ($payload as $member => $value) {
            $member = "i". $member;
            $array[$member] = $value;
        }
        return $array;
    }
}
