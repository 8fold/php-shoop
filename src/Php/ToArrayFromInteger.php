<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class ToArrayFromInteger extends Filter
{
    private $start = 0;

    public function __construct(int $start = 0)
    {
        $this->start = $start;
    }

    public function __invoke(int $payload): array
    {
        return ($this->start > $int)
            ? range($payload, $this->start)
            : range($this->start, $payload);
    }
}
