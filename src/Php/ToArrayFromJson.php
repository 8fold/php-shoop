<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToArrayFromJson extends Bend
{
    public function __invoke(string $payload): array
    {
        $notJson = Shoop::pipeline($payload,
            StringIsJson::bend(),
            ReverseBool::bend()
        )->unfold();
        if ($notJson) { return []; }

        return Shoop::pipeline($payload,
            ToObjectFromJson::bend(),
            ToArrayFromObject::bend()
        )->unfold();
    }
}
