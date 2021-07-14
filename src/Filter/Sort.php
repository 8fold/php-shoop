<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Is\IsIdenticalTo;

/**
 * @todo - invocation
 */
class Sort extends Filter
{
    public function __invoke($using): array
    {
        if (Is::object(false)->unfoldUsing($using)) {
        //     if (Is::object()->unfoldUsing($using)) {
        //         return static::fromObject($using);
        //     }
        //     return static::fromTuple($using);

        // } elseif (Is::boolean()->unfoldUsing($using)) {
        //     return static::fromBoolean($using);

        // } elseif (Is::number()->unfoldUsing($using)) {
        //     return static::fromNumber($using);

        } elseif (Is::list()->unfoldUsing($using)) {
            return static::fromList($using, $this->main);

        // } elseif (Is::string()->unfoldUsing($using)) {
        //     if (Is::json()->unfoldUsing($using)) {
        //         return static::fromJson($using);
        //     }
        //     return static::fromString($using);
        }
    }

    static public function fromList(array $using, int|callable $flags): array
    {
        if (is_int($flags)) {
            asort($using, $flags);

        } else {
            uasort($using, $flags);

        }
        return $using;
    }
}
