<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

class ToDictionaryFromBoolean extends Bend
{
    public function __invoke(bool $payload): array
    {
        return ($payload === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }
}
