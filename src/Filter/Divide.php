<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Is\IsIdenticalTo;

/**
 * @todo - invocation, rename to DivideBy
 */
class Divide extends Filter
{
    public function __invoke($using)
    {
    }

    /**
     * true, true  : back and front
     * true, false : front only
     * false, true : back only
     * false, false: all occurrences
     *
     * TODO: PHP 8 - string, bool, bool, array|int
     */
    static public function fromString(
        string $using,
        string $divisor      = "",
        bool $includeEmpties = true,
        int $count           = PHP_INT_MAX
    ): array
    {
        if (IsIdenticalTo::fromString($divisor, "")) {
            return mb_str_split($using);
        }
        // $fromStartAndEnd = ($fromStart and $fromEnd) ? true : false;
        // $all             = (! $fromStart and ! $fromEnd) ? true : false;

        // if ($fromStartAndEnd) {
        //     $charMask = TypeAsString::apply()->unfoldUsing($charMask);
        //     return trim($using, $charMask);

        // } elseif ($fromStart) {
        //     $charMask = TypeAsString::apply()->unfoldUsing($charMask);
        //     return ltrim($using, $charMask);

        // } elseif ($fromEnd) {
        //     $charMask = TypeAsString::apply()->unfoldUsing($charMask);
        //     return rtrim($using, $charMask);

        // } elseif ($all) {
        //     return str_replace($charMask, "", $using);

        // }
    }

    // TODO: PHP 8 - int|float, int|float -> int|float
    static public function fromNumber($using, $subtracter)
    {
        return $using - $subtracter;
    }

    /**
     * true, true  : back and front
     * true, false : front only
     * false, true : back only
     * false, false: all occurrences
     */
    private function fromList(
        array $using,
        $count          = 1, // TODO: PHP 8 - int|array
        bool $fromStart = true,
        bool $fromEnd   = true
    ): array
    {
        if ($fromStart and $fromEnd and $count >= count($using)) {
            return [];

        } elseif (! $fromStart and ! $fromEnd) {
            if (! is_array($count)) {
                $count = [$count];
            }
            return array_filter($using, function($v, $k) use ($count) {
                return ! in_array($v, $count, true);
            }, ARRAY_FILTER_USE_BOTH);

        } elseif ($fromStart and $fromEnd) {
            $length = count($using) - (2 * $count);
            return array_slice($using, $count, $length, true);

        }

        if ($fromStart) {
            $length = count($using) - $count;
            $using = array_slice($using, -$length, $length, true);

        }

        if ($fromEnd) {
            $length = count($using) - $count;
            $using = array_slice($using, 0, $length, true);

        }
        return $using;
    }
}
