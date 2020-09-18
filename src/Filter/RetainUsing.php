<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

/**
 * @todo - invocation
 */
class RetainUsing extends Filter
{
    public function __invoke(string $using): bool
    {
    }

    static public function fromList(
        array $using,
        callable $filter,
        bool $useValue  = true,
        bool $useMember = false
    ): array
    {
        if ($useValue and $useMember) {
            return array_filter($using, $filter, ARRAY_FILTER_USE_BOTH);

        } elseif (! $useValue and $useMember) {
            return array_filter($using, $filter, ARRAY_FILTER_USE_KEY);

        }
        return array_filter($using, $filter);
    }
}
