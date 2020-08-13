<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use \stdClass;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToJsonFromObject extends Bend
{
    public function __invoke(object $payload): string
    {
        return json_encode($payload);
    }
}
