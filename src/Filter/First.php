<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Is\IsIdentical;

/**
 * @todo - invocation
 */
class First extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromString(string $using, int $length = 1): string
    {
        $array = Divide::fromString($using);

        $first = static::fromList($array, $length);
        if (IsIdentical::fromNumber($length, 1)) {
            return $first;
        }

        return AsString::fromList($first);
    }

    static public function fromList(array $using, int $length = 1)
    {
        $build = From::fromList($using, 0, $length);
        return (IsIdentical::fromNumber($length, 1)) ? $build[0] : $build;
    }
}
