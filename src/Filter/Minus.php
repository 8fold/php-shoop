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
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }

            $filtered = array_filter($using, function($v, $k) {
                return ! in_array($v, $this->main, true);
            }, ARRAY_FILTER_USE_BOTH);

            if (TypeIs::applyWith("dictionary")->unfoldUsing($filtered)) {
                return $filtered;

            }
            return TypeAsArray::apply()->unfoldUsing($filtered);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $this->fromString($using, ...$this->args(true));

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Minus::applyWith($this->main),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                Minus::applyWith($this->main)
            )->unfold();

        }
    }

    static private function fromString(
        string $using,
        bool $fromStart = true,
        bool $fromEnd   = true,
        array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"]
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
