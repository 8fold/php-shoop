<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class FirstFromArray extends Bend
{
    // TODO: Test using this for string starts with
    public function __invoke(array $payload)
    {
        return array_shift($payload);
    }
}
