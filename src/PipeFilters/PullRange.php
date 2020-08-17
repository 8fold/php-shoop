<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class PullRange extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke($using)
    {
        if (IsList::apply()->unfoldUsing($using)) {
            $preserveKeys = true;
            if (IsArray::applyWith(true)->unfoldUsing($using)) {
                $preserveKeys = false;

            }
            return array_slice($using, $this->start, $this->length, $preserveKeys);
        }

        if (IsString::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsArray::apply(),
                PullRange::applyWith($this->start, $this->length),
                AsString::apply()
            )->unfold();

        // TODO: Maybe all of these need to return the original type?? Running
        //      into issue when attempting, not sure how critical that is. Let's
        //      get the migration done first.
        } elseif (IsBoolean::apply()->unfoldUsing($using) or
            UsesStringMembers::apply()->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                AsDictionary::apply(),
                PullRange::applyWith($this->start, $this->length)
            )->unfold();

        } else {
            return Shoop::pipe($using,
                AsArray::apply(),
                PullRange::applyWith($this->start, $this->length)
            )->unfold();

        }
    }
}
