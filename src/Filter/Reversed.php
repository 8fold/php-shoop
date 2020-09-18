<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\MultipliedBy;

use Eightfold\Shoop\Filter\TypeJuggling\AsString;

/**
 * @todo - invocation
 */
class Reversed extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromBoolean(bool $using): bool
    {
        return ! $using;
    }

    // TODO: PHP 8 - int|float -> int|float
    static public function fromNumber($using)
    {
        return MultipliedBy::fromNumber($using, -1);
    }

    static public function fromString(string $using): string
    {
        $array = Divide::fromString($using);
        $array = static::fromList($array);

        return AsString::fromList($array);
    }

    static public function fromList(array $array): array
    {
        return array_reverse($array);
    }

    static public function fromTuple($using): array
    {
        $dictionary = AsDictionary::fromTuple($using);
        $reversed   = static::fromList($array);
        return AsTuple::fromList($reversed);
    }

    static public function fromJson(string $using): string
    {
        $dictionary = static::fromTuple($using);
        return AsJson::fromList($dictionary);
    }

    static public function fromObject(object $using): object
    {
        if (IsReversible::apply()->unfoldUsing($using)) {
            return $using->reversed();
        }
        return static::fromTuple($using);
    }
}
