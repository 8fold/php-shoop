<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\PullFirst\FromArray;

class PullFirst extends Filter
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

    public function __invoke($using): array
    {
        if (IsArray::apply()->unfoldUsing($using) or
            IsDictionary::apply()->unfoldUsing($using)
        ) {
            return FromArray::applyWith($this->length, $this->startAt)
                ->unfoldUsing($using);
        }

        if (UsesStringMembers::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                PullFirst::applyWith($this->length, $this->startAt)
            )->unfold();
        }
        return Shoop::pipe($using,
            AsArray::apply(),
            PullFirst::applyWith($this->length, $this->startAt)
        )->unfold();
    }
}
