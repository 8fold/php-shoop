<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpIndexedArray,
    PhpAssociativeArray
};

class PhpObject
{
    // TODO: No tests failed - need tests
    static public function startsWith(object $object, array $needles): bool
    {
        $dictionary = self::toAssociativeArray($object);
        $bool = PhpAssociativeArray::startsWith($dictionary, $needles);
        return $bool;
    }

    static public function endsWith(object $object, array $needles): bool
    {
        $dictionary = self::toAssociativeArray($object);
        $bool = PhpAssociativeArray::endsWith($dictionary, $needles);
        return $bool;
    }

    static public function afterRemovingMembers(object $object, array $members): object
    {
        foreach ($members as $member) {
            if (method_exists($object, $member) or property_exists($object, $member)) {
                unset($object->{$member});
            }
        }
        return $object;
    }

    static public function hasMember(\stdClass $object, string $member): bool
    {
        return property_exists($object, $member);
    }
}
