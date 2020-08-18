<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromArray as AsIntegerFromArray;

class FromDictionary extends Filter
{
    private $members = "";

    public function __construct(string ...$members)
    {
        $this->members = $members;
    }

    // TODO: PHP 8.0 - not null -> int|float|string|array|object
    public function __invoke(array $using)
    {
        if (AsIntegerFromArray::apply()->unfoldUsing($this->members) === 1) {
            $member = $this->members[0];
            if (isset($using[$member])) {
                return $using[$member];

            }
        }

        $build = [];
        foreach ($this->members as $member) {
            if (isset($using[$member])) {
                $build[$member] = $using[$member];
            }
        }
        return $build;
    }
}
