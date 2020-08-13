<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use \stdClass;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToObjectFromJson extends Bend
{
    public function __invoke(string $payload): object
    {
        $notJson = Shoop::pipeline($payload,
            StringIsJson::bend(),
            ReverseBool::bend()
        )->unfold();
        if ($notJson) { return new stdClass; }

        return json_decode($payload);
    }
}
