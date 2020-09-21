<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

/**
 * @todo Test
 */
class Prepend extends Filter
{
    public function __invoke($using)
    {
        // if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
        //     TypeIs::applyWith("number")->unfoldUsing($using)
        // ) {
        //     return Apply::plus($this->value)->unfoldUsing($using);

        // } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
        //     if (! TypeIs::applyWith("list")->unfoldUsing($this->value)) {
        //         $this->value = [$this->value];
        //     }
        //     return Apply::concatenate($using)->unfoldUsing($this->value);

        // } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
        //     return Apply::concatenate($using)->unfoldUsing($this->value);

        // } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
        //     if (TypeIs::applyWith("number")->unfoldUsing($this->value)) {
        //         $this->value = [$this->value];

        //     }

        //     if (! TypeIs::applyWith("dictionary")->unfoldUsing($this->value)) {
        //         $this->value = Apply::typeAsDictionary()
        //             ->unfoldUsing($this->value);
        //     }

        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         Prepend::applyWith($this->value),
        //         TypeAsJson::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
        //     if (TypeIs::applyWith("number")->unfoldUsing($this->value)) {
        //         $this->value = [$this->value];

        //     }

        //     if (! TypeIs::applyWith("dictionary")->unfoldUsing($this->value)) {
        //         $this->value = Apply::typeAsDictionary()
        //             ->unfoldUsing($this->value);

        //     }

        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         Prepend::applyWith($this->value),
        //         TypeAsTuple::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsTuple::apply(),
        //         Prepend::applyWith($this->value)
        //     )->unfold();

        // }
    }

    static public function fromString(string $using, string $prefix): string
    {
        return Append::fromString($prefix, $using);
    }

    static public function fromList(array $using, array $prefix)
    {
        return Append::fromList($prefix, $using);
    }
}
