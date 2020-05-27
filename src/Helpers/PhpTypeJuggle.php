<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\{
    PhpIndexedArray,
    PhpBool,
    PhpAssociativeArray,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESArray,
    ESDictionary,
    ESObject,
    ESJson
};
class PhpTypeJuggle
{
    static public function juggleTo(Shooped $instance, string $className)
    {
        $value = null;
        if (Type::is($instance, ESArray::class)) {
            if ($className === ESArray::class) {
                $value = $instance->value();

            } elseif ($className === ESBool::class) {
                $value = PhpIndexedArray::toBool($instance->value());

            } elseif ($className === ESDictionary::class) {
                $value = PhpIndexedArray::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = PhpIndexedArray::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = PhpIndexedArray::toJson($instance->value());

            } elseif ($className === ESObject::class) {
                $value = PhpIndexedArray::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = PhpIndexedArray::toString($instance->value());

            }

        } elseif (Type::is($instance, ESBool::class)) {
            if ($className === ESArray::class) {
                $value = PhpBool::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = $instance->value();

            } elseif ($className === ESDictionary::class) {
                $value = PhpBool::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = PhpBool::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = PhpBool::toJson($instance->value());

            } elseif ($className === ESObject::class) {
                $value = PhpBool::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = PhpBool::toString($instance->value());

            }

        } elseif (Type::is($instance, ESDictionary::class)) {
            if ($className === ESArray::class) {
                $value = PhpAssociativeArray::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = PhpAssociativeArray::toBool($instance->value());;

            } elseif ($className === ESDictionary::class) {
                $value = $instance->value();

            } elseif ($className === ESInt::class) {
                $value = PhpAssociativeArray::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = PhpAssociativeArray::toJson($instance->value());

            } elseif ($className === ESObject::class) {
                $value = PhpAssociativeArray::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = PhpAssociativeArray::toString($instance->value());

            }

        } elseif (Type::is($instance, ESInt::class)) {
            if ($className === ESArray::class) {
                $value = PhpInt::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = PhpInt::toBool($instance->value());

            } elseif ($className === ESDictionary::class) {
                $value = PhpInt::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = $instance->value();

            } elseif ($className === ESJson::class) {
                $value = PhpInt::toJson($instance->value());

            } elseif ($className === ESObject::class) {
                $value = PhpInt::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = PhpInt::toString($instance->value());

            }

        } elseif (Type::is($instance, ESJson::class)) {
            if ($className === ESArray::class) {
                $value = PhpJson::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = PhpJson::toBool($instance->value());

            } elseif ($className === ESDictionary::class) {
                $value = PhpJson::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = PhpJson::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = $instance->value();

            } elseif ($className === ESObject::class) {
                $value = PhpJson::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = $instance->value();

            }

        } elseif (Type::is($instance, ESObject::class)) {
            if ($className === ESArray::class) {
                $value = PhpObject::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = PhpObject::toBool($instance->value());

            } elseif ($className === ESDictionary::class) {
                $value = PhpObject::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = PhpObject::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = PhpObject::toJson($instance->value());

            } elseif ($className === ESObject::class) {
                $value = $instance->value();

            } elseif ($className === ESString::class) {
                $value = PhpObject::toString($instance->value());

            }

        } elseif (Type::is($instance, ESString::class)) {
            if ($className === ESArray::class) {
                $value = PhpString::toIndexedArray($instance->value());

            } elseif ($className === ESBool::class) {
                $value = PhpString::toBool($instance->value());

            } elseif ($className === ESDictionary::class) {
                $value = PhpString::toAssociativeArray($instance->value());

            } elseif ($className === ESInt::class) {
                $value = PhpString::toInt($instance->value());

            } elseif ($className === ESJson::class) {
                $value = $instance->value();

            } elseif ($className === ESObject::class) {
                $value = PhpString::toObject($instance->value());

            } elseif ($className === ESString::class) {
                $value = $instance->value();

            }
        }

        if ($value === null) {
            trigger_error(get_class($instance) ." cannot be converted to ". $className);
        }
        return $className::fold($value);
    }

// -> Generic
    static public function arrayToInt(array $array = []): int
    {
        return count($array);
    }

    static public function arrayToString(array $array = []): string
    {
        $printed = print_r($array, true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return trim($fixSpacingWhenEmpty);
    }
}
