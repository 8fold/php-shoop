<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullFirst;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class FromArray extends Filter
{
    private $length = 1;
    private $startAt = 0;

    public function __construct(int $length = 1, int $startAt = 0)
    {
        if ($length < 0) {
            // always from start
            $length = -$length;
        }
        $this->length = $length;
        $this->startAt = $startAt;
    }

    public function __invoke(array $using): array
    {
        return array_slice($using, $this->startAt, $this->length);
    }
}
