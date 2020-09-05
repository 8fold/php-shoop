<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Minus extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                Minus::applyWith($this->main),
                TypeAsBoolean::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }

            $int = array_sum($this->main);
            return $using - $int;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $base = $this->fromList($using, ...$this->args(true));
            if (TypeIs::applyWith("array")->unfoldUsing($using)) {
                return TypeAsArray::apply()->unfoldUsing($base);
            }
            return $base;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            $args = $this->args(true);
            $args = array_filter($args);
            return $this->fromString($using, ...$args);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Minus::applyWith(...$this->args(true)),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                Minus::applyWith(...$this->args(true))
            )->unfold();

        }
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

    /**
     * true, true  : back and front
     * true, false : front only
     * false, true : back only
     * false, false: all occurrences
     *
     * TODO: PHP 8 - string, bool, bool, array|int
     */
    private function fromString(
        string $using,
        array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"],
        bool $fromStart = true,
        bool $fromEnd   = true
    ): string
    {
        $fromStartAndEnd = ($fromStart and $fromEnd) ? true : false;
        $all             = (! $fromStart and ! $fromEnd) ? true : false;

        if ($fromStartAndEnd) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return trim($using, $charMask);

        } elseif ($fromStart) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return ltrim($using, $charMask);

        } elseif ($fromEnd) {
            $charMask = TypeAsString::apply()->unfoldUsing($charMask);
            return rtrim($using, $charMask);

        } elseif ($all) {
            return str_replace($charMask, "", $using);

        }
    }
}
