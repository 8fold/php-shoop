<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Members;
use Eightfold\Shoop\Filter\Reversed;
use Eightfold\Shoop\Filter\RetainUsing;
use Eightfold\Shoop\Filter\At;

use Eightfold\Shoop\Filter\Is\IsJson;
use Eightfold\Shoop\Filter\Is\IsNumber;
use Eightfold\Shoop\Filter\Is\IsObject;

use Eightfold\Shoop\Filter\Implementing\IsTupleable;
use Eightfold\Shoop\Filter\Implementing\IsAssociable;

/**
 * @todo invocation
 */
class AsDictionary extends Filter
{
    public function __invoke($using): array
    {
    }

    static public function fromBoolean(bool $using): array
    {
        return ($using)
            ? ["false" => false, "true" => true]
            : ["false" => true, "true" => false];
    }

    // TODO: PHP 8 - int|float
    static public function fromNumber($using): array
    {
        $array = AsArray::fromNumber($using);
        return static::fromList($array);
    }

    static public function fromString(string $using): array
    {
        return ["content" => $using];
    }

    static public function fromList(array $using): array
    {
        $callable = function($value, $member, &$build) {
            // TODO: if member is not string, convert to string
            if (IsNumber::apply()->unfoldUsing($member)) {
                $member = AsString::fromNumber($member);
            }
            $build[$member] = $value;
        };

        return static::each($using, $callable);
    }

    static private function each(array &$using, callable $callable): array
    {
        $build = [];
        $break = false;
        foreach ($using as $member => $value) {
            if ($break) {
                break;
            }
            $callable($value, $member, $build, $break);
        }
        return $build;
    }

    // TODO: PHP 8 - string|object
    static public function fromTuple($using): array
    {
        if (IsTupleable::apply()->unfoldUsing($using)) {
            $using = $using->efToTuple();

        } elseif (IsJson::apply()->unfoldUsing($using)) {
            return static::fromJson($using);

        }

        $isObject = IsObject::applyWith(false)->unfoldUsing($using);
        if (Reversed::fromBoolean($isObject)) {
            return [];

        }

        $members = Members::fromObject($using);
        $props   = At::fromDictionary($members, ["properties"]);

        $filter = function($v, $k) {
            return $v !== null and ! is_a($v, Closure::class);
        };

        return RetainUsing::fromList($props, $filter, true, true);
    }

    static public function fromJson(string $using): array
    {
        $tuple = AsTuple::fromJson($using);
        return static::fromTuple($tuple);
    }

    static public function fromObject(object $using): array
    {
        if (IsAssociable::apply()->unfoldUsing($using)) {
            return $using->efToDictionary();
        }
        return static::fromTuple($using);
    }
}
