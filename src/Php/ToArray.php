<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToArray extends Bend
{
    public function __invoke($payload): array
    {
        if (is_object($payload)) {
            // ToArrayFromObject

        }
        return ($this->start > $int)
            ? range($payload, $this->start)
            : range($this->start, $payload);
    }
}
