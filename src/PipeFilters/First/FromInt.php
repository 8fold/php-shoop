<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\First;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\First;

class FromInt extends Filter
{
    private $length = 1;
    private $start = 0;

    public function __construct(int $length = 1, int $start = 0)
    {
        $this->length = $length;
        $this->start = $start;
    }

    public function __invoke(int $payload): array
    {
        return Shoop::pipe($payload,
            AsArray::applyWith($this->start),
            First::applyWith($this->length)
        )->unfold();
    }
}
