<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Span;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsArray;

class FromList extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke(array $using): array
    {
        $preserveKeys = true;
        if (IsArray::applyWith(true)->unfoldUsing($using)) {
            $preserveKeys = false;

        }
        return array_slice($using, $this->start, $this->length, $preserveKeys);
    }
}
