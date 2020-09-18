<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Type;

use Eightfold\Shoop\Filter\Is\Not\IsNotEmpty;

use Eightfold\Shoop\Filter\Implementing\IsFalsifiable;

/**
 * @todo invocation
 */
class AsBoolean extends Filter
{
    public function __invoke($using): bool
    {

    }

    static public function fromBoolean(bool $using): bool
    {
        return IsNotEmpty::fromBoolean($using);
    }

    static public function fromString(string $using): bool
    {
        return IsNotEmpty::fromString($using);
    }

    // TODO: PHP 8.0 - int|float
    static public function fromNumber($using): bool
    {
        return IsNotEmpty::fromNumber($using);
    }

    static public function fromList(array $using): bool
    {
        return IsNotEmpty::fromList($using);
    }

    // TODO: PHP 8 - object|string
    static public function fromTuple($using): bool
    {
        return IsNotEmpty::fromTuple($using);
    }

    static public function fromJson(string $using): bool
    {
        return static::fromTuple($using);
    }

    static public function fromObject(object $using): bool
    {
        if (IsFalsifiable::apply()->unfoldUsing($using)) {
        // if (is_a($using, Falsifiable::class)) {
            return $using->efToBoolean();
        }
        return IsNotEmpty::fromObject($using);
    }
}
