<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Is\IsIdentical;

/**
 * @todo - invocation
 */
class Last extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromString(string $using, int $length = 1): string
    {
        $array = Divide::fromString($using);

        $last = static::fromList($array, $length);
        if (IsIdentical::fromNumber($length, 1)) {
            return $last;
        }

        $array = Reversed::fromList($last);
        return AsString::fromList($array);
    }

    static public function fromList(array $using, int $length = 1)
    {
        $count = Count::fromList($using);

        $start = Minus::fromNumber($count, $length);
        $build = From::fromList($using, $start, $length);
        return (IsIdentical::fromNumber($length, 1)) ? array_pop($build) : $build;
    }
}