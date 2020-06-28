<?php

namespace Eightfold\Shoop\Helpers;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray,
    PhpObject
};

class SymfonyYaml
{
    static public function toIndexedArray(string $yaml): array
    {
        self::isYaml($yaml);
        $associativeArray = self::toAssociativeArray($yaml);
        return PhpAssociativeArray::toIndexedArray($associativeArray);
    }

    static public function toBool(string $yaml): bool
    {
        self::isYaml($yaml);
        $associativeArray = self::toAssociativeArray($yaml);
        return PhpAssociativeArray::toBool($associativeArray);
    }

    static public function toAssociativeArray(string $yaml): array
    {
        self::isYaml($yaml);
        $parsed = Yaml::parse($yaml);
        return ($parsed === null) ? [] : $parsed;
    }

    static public function toInt(string $yaml): int
    {
        self::isYaml($yaml);
        $associativeArray = self::toAssociativeArray($yaml);
        return PhpAssociativeArray::toInt($associativeArray);
    }

    static public function toJson(string $yaml): string
    {
        self::isYaml($yaml);
        $object = self::toObject($yaml);
        return PhpObject::toJson($object);
    }

    static public function toObject(string $yaml): object
    {
        self::isYaml($yaml);
        $associativeArray = self::toAssociativeArray($yaml);
        return PhpAssociativeArray::toObject($associativeArray);
    }

    static public function isYaml(string $yaml): void
    {
        if (Type::isNotYaml($yaml)) {
            trigger_error("The given string does not appear to be valid YAML.", E_USER_ERROR);
        }
    }

    // TODO: Tests and implementation
    static public function afterSettingValue(string $yaml, $value, $member, bool $overwrite = true): string
    {
        // self::isYaml($yaml);
        // $object = self::toObject($yaml);
        // $object = PhpObject::afterSettingValue($object, $value, $member, $overwrite);

        // self::isJson($json);
        // $object = self::toObject($json);
        // $object = PhpObject::afterSettingValue($object, $value, $member, $overwrite);
        // $json = PhpObject::toJson($object);
        // return $json;
    }

    static public function toMembersAndValuesAssociativeArray(string $yaml): string
    {
        // self::isJson($json);
        // $object = self::toObject($json);
        // $object = PhpObject::toMembersAndValuesAssociativeArray($object);
        // $json = PhpObject::toJson($object);
        // return $json;
    }

    static public function hasMember(string $yaml, string $member): bool
    {
        // self::isJson($json);
        // $object = self::toObject($json);
        // return property_exists($object, $member);
    }
}
