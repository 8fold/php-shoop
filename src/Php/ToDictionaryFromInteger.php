<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToDictionaryFromInteger extends Bend
{
    public function __invoke(int $payload): array
    {
        return Shoop::pipeline($payload,
            ToArrayFromInteger::bend(),
            ToDictionaryFromArray::bend())
        ->unfold();
    }
}
