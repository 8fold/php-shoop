<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToStringFromObject extends Bend
{
    public function __invoke(object $payload): string
    {
        if (method_exists($payload, "__toString")) {
            return (string) $payload;
        }

        return Shoop::pipeline($payload,
            ToDictionaryFromObject::bend($payload),
            ToStringFromArray::bend($array)
        )->unfold();
    }
}
