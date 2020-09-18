<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Type;

use Eightfold\Shoop\Filter\Implementing\IsCountable;

/**
 * @todo invocation
 */
class AsInteger extends Filter
{
    public function __invoke($using)
    {
    }

    // TODO: PHP 8 -> int|float
    static public function fromBoolean(bool $using): int
    {
        return (int) $using;
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): int
    {
        return (int) round($using); // TODO: Round filter
    }

    /**
     * If the string starts with a letter, 0 will be returned.
     *
     * If the string starts with a number, any characters following a numeric sequence are dropped. ex. 30he77o outputs 30
     */
    static public function fromString(string $using): int
    {
        return (int) $using;
    }

    static public function fromList(array $using): int
    {
        return (int) $using;
    }

    static public function fromTuple($using): int
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): int
    {
        return static::fromTuple($using);
    }

    static public function fromObject(object $using): int
    {
        if (IsCountable::apply()->unfoldUsing($using)) {
            return $using->efToInteger();
        }
        return static::fromTuple($using);
    }
}
