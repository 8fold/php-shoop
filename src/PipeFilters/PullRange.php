<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class PullRange extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke($using): array
    {
        if (IsList::apply()->unfoldUsing($using)) {
            $list = array_slice($using, $this->start, $this->length, true);
            if (IsArray::applyWith(true)->unfoldUsing($list)) {
                return AsArray::apply()->unfoldUsing($list);
            }
            return $list;
        }
    }
}
