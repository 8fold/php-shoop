<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToArrayFromJson extends Filter
{
    public function __invoke(string $payload): array
    {
        $notJson = Shoop::pipe($payload,
            StringIsJson::apply(),
            ReverseBool::apply()
        )->unfold();
        if ($notJson) { return []; }

        return Shoop::pipe($payload,
            ToObjectFromJson::apply(),
            ToArrayFromObject::apply()
        )->unfold();
    }
}
