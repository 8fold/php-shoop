<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\Is;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Reversed;
use Eightfold\Shoop\Filter\Members;
use Eightfold\Shoop\Filter\Count;

use Eightfold\Shoop\Filter\TypeJuggling\AsDictionary;
use Eightfold\Shoop\Filter\TypeJuggling\AsTuple;

use Eightfold\Shoop\Filter\Implementing\IsEmptiable;

/**
 * @todo invocation
 */
class IsEmpty extends Filter
{
    public function __invoke($using): bool
    {
    }

    static public function fromBoolean(bool $using): bool
    {
        return empty($using);
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): bool
    {
        return empty($using);
    }

    static public function fromString(string $using): bool
    {
        return empty($using);
    }

    static public function fromList(array $using): bool
    {
        return empty($using);
    }

    // TODO: PHP 8 - object|string
    static public function fromTuple($using): bool
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): bool
    {
        return static::fromTuple($using);
    }

    static public function fromObject(object $using): bool
    {
        if (IsEmptiable::apply()->unfoldUsing($using)) {
            return $using->efIsEmpty();
        }

        $tuple = AsTuple::fromObject($using);
        return static::fromTuple($using);
    }
}
