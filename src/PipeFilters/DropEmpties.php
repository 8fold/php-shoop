<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

// TODO: rename to "clear"??
class DropEmpties extends Filter
{
    private $callback;

    public function __construct(callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function __invoke(array $using): array
    {
        return ($this->callback === null)
            ? array_filter($using)
            : array_filter($using, $this->callback);
    }
}