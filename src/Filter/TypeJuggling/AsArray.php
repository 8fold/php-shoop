<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Type;

use Eightfold\Shoop\Filter\Is\IsEmpty;

use Eightfold\Shoop\Filter\Implementing\IsArrayable;

use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;

/**
 * @todo invocation
 */
class AsArray extends Filter
{
    public function __invoke($using): array
    {
    }

    static public function fromBoolean(bool $using): array
    {
        $dictionary = AsDictionary::fromBoolean($using);
        return AsArray::fromList($dictionary);
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): array
    {
        return (array) $using;
    }

    static public function fromString(string $using): array
    {
        $dictionary = AsDictionary::fromString($using);
        return static::fromList($dictionary);
    }

    static public function fromList(array $using): array
    {
        return array_values($using);
    }

    // TODO: PHP 8 - string|object
    static public function fromTuple($using): array
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): array
    {
        return static::fromTuple($using);
    }

    static public function fromObject(object $using): array
    {
        if (IsArrayable::apply()->unfoldUsing($using)) {
            return $using->efToArray();
        }
        return static::fromTuple($using);
    }
}
