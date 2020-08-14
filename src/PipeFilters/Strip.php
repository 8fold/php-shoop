<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

// TODO: rename to "clear"??
class Strip extends Filter
{
    private $callback;

    public function __construct(callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function __invoke(array $payload): array
    {
        return ($this->callback === null)
            ? array_filter($payload)
            : array_filter($payload, $this->callback);
    }
}
