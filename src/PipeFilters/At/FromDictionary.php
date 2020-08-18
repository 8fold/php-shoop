<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

class FromDictionary extends Filter
{
    private $member = "";

    public function __construct(string $member = "")
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
