<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

// TODO: rename IsGreaterThan
class IntegerIsGreaterThan extends Filter
{
    private $int = 0;

    public function __construct(int $int = 0)
    {
        $this->int = $int;
    }

    public function __invoke(int $using): bool
    {
        return $using > $this->int;
    }
}
