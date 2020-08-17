<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullFirst\FromArray;

class PullFirst extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        if ($length < 0) {
            // always from start
            $length = -$length;
        }
        $this->length = $length;
    }

    public function __invoke($using): array
    {
        if (IsList::apply()->unfoldUsing($using)) {
            return PullRange::applyWith(0, $this->length)->unfoldUsing($using);

        }

        if (UsesStringMembers::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                PullFirst::applyWith($this->length)
            )->unfold();

        } else {
            return Shoop::pipe($using,
                AsArray::apply(),
                PullFirst::applyWith($this->length)
            )->unfold();

        }
    }
}
