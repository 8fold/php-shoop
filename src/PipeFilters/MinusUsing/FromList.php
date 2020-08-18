<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\MinusUsing;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromList as AsArrayFromList;

class FromList extends Filter
{
    private $callback;

    public function __construct(callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function __invoke(array $using): array
    {
        $filtered = ($this->callback === null)
            ? array_filter($using)
            : array_filter($using, $this->callback);

        return AsArrayFromList::apply()->unfoldUsing($filtered);
    }
}
