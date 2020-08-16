<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsNumber extends Filter
{
    private $floatStrict = false;

    public function __construct(bool $floatStrict = false)
    {
        $this->floatStrict = $floatStrict;
    }

    public function __invoke($using): bool
    {
        if (! is_int($using) and ! is_float($using)) return false;

        if ($this->floatStrict) return is_float($using);

        return true;
    }
}
