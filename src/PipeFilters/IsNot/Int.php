<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\IsNot;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Int extends Filter
{
    private $compare = 0;

    public function __construct(int $compare = 0)
    {
        $this->compare = $compare;
    }

    public function __invoke(int $using): bool
    {
        return $using !== $this->compare;
    }
}
