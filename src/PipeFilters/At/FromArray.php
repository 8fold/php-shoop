<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

class FromArray extends Filter
{
    private $member = 0;

    // TODO: PHP 8.0 - int|float|string
    public function __construct(int $member = 0)
    {
        $this->member = $member;
    }

    // TODO: PHP 8.0 - not null -> int|float|string|array|object
    public function __invoke(array $using)
    {
        if (isset($using[$this->member])) {
            return $using[$this->member];
        }
        return [];
    }
}
