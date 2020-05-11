<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\PhpTypeJuggle;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESInt,
    ESString,
    ESObject,
    ESJson,
    ESDictionary
};

trait MathOperationsImp
{
    public function count(): ESInt
    {
        $int = $this->int();
        if (Type::is($this, ESString::class)) {
            $int = strlen($this->value);
        }
        return Shoop::int($int);
    }

    public function plus(...$args)
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $count = count($args);
            if ($count === 0) {
                return static::fold($array);
            }
            $merged = array_merge($array, $args);
            return Shoop::array($merged);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->value;
            $suffixes = $this->indexedArrayToValueMemberArray($args);
            $dictionary = array_merge($dictionary, $suffixes);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $total = $this->value;
            foreach ($args as $term) {
                $term = Type::sanitizeType($term, ESInt::class)->unfold();
                $total += $term;
            }
            return Shoop::int($total);

        } elseif (Type::is($this, ESJson::class)) {
            $dictionary = $this->indexedArrayToValueMemberArray($args);
            $object = json_decode($this->value);
            foreach ($dictionary as $member => $value) {
                $object->{$member} = $value;
            }
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $dictionary = $this->indexedArrayToValueMemberArray($args);
            $object = (object) $dictionary;
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $total = $this->unfold();
            $terms = $args;
            foreach ($terms as $term) {
                $term = Type::sanitizeType($term, ESString::class)->unfold();
                $total .= $term;
            }
            return Shoop::string($total);
        }
    }

    public function minus(...$args)
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $a = array_filter($array, function($index) use ($args) {
                return ! in_array($index, $args);
            }, ARRAY_FILTER_USE_KEY);
            $a = array_values($a);
            return Shoop::array($a);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $a = array_filter($array, function($index) use ($args) {
                return ! in_array($index, $args);
            }, ARRAY_FILTER_USE_KEY);
            $a = array_values($a);
            return Shoop::dictionary($a);

        } elseif (Type::is($this, ESInt::class)) {
            $total = $this->value;
            foreach ($args as $term) {
                $term = Type::sanitizeType($term, ESInt::class)->unfold();
                $total -= $term;
            }
            return Shoop::int($total);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            $object = $this->removeMembersFromObject($object, $args);
            $json = PhpTypeJuggle::objectToJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            $object = $this->removeMembersFromObject($object, $args);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            return Shoop::string(str_replace($args, "", $this->unfold()));

        }
    }

    public function divide($divisor = 0)
    {
        // TODO: Consider putting $removeEmpties boolean back in
        if (Type::is($this, ESArray::class)) {
            $divisor = Type::sanitizeType($divisor, ESInt::class)->unfold();
            $array = $this->array()->splitAtUnfolded($divisor);
            $left = $array["lhs"];
            $right = $array["rhs"];
            return Shoop::array([$left, $right]);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->dictionaryUnfolded();
            $dictionary = $this->dictionaryToDictionaryOfMembersAndValues($dictionary);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->intUnfolded();
            $divisor = Type::sanitizeType($divisor, ESInt::class)->unfold();
            $int = (int) round($int/$divisor);
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectToObjectWithMembersAndValues($object);
            $json = PhpTypeJuggle::objectToJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectToObjectWithMembersAndValues($object);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $array = explode($divisor, $string);
            return Shoop::array($array);

        }
    }

    public function multiply($multiplier = 1)
    {
        if (Type::is($this, ESArray::class, ESDictionary::class, ESJson::class, ESObject::class)) {
            $product = [];
            for ($i = 0; $i < $multiplier; $i++) {
                $product[] = $this;
            }
            return Shoop::array($product);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->intUnfolded();
            $multiplier = Type::sanitizeType($multiplier, ESInt::class)->unfold();
            $product = $int * $multiplier;
            return Shoop::int($product);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $multiplier = Type::sanitizeType($multiplier, ESInt::class)->unfold();
            $repeated = str_repeat($string, $multiplier);

            return Shoop::string($repeated);

        }
    }

    private function argCountIsEven(array $args): bool
    {
        $count = count($args);
        return ($count % 2 == 0)
            ? true
            : false;
    }

    private function argCountIsOdd(array $args): bool
    {
        return ! $this->argCountIsEven($args);
    }

    private function indexedArrayToValueMemberArray(array $args): array
    {
        if ($this->argCountIsOdd($args)) {
            $className = static::class;
            $argCount = count($args);
            trigger_error(
                "{$className}::indexedArrayToValueMemberArray() expects two (or more) arguments. {$argCount} given."
            );
        }
        $count = 0;
        $members = [];
        $values = [];
        foreach ($args as $value) {
            if ($count === 0 or $count % 2 === 0) {
                $values[] = $value;

            } else {
                $members[] = $value;

            }
            $count++;
        }
        $dictionary = array_combine($members, $values);
        return $dictionary;
    }

    private function removeMembersFromObject(object $object, array $members): object
    {
        foreach ($members as $member) {
            if (method_exists($object, $member) or property_exists($object, $member)) {
                unset($object->{$member});
            }
        }
        return $object;
    }

    private function dictionaryToDictionaryOfMembersAndValues(array $dictionary): array
    {
        $left = array_keys($dictionary);
        $right = PhpTypeJuggle::associativeArrayToIndexedArray($dictionary);
        $dictionary = ["members" => $left, "values" => $right];
        return $dictionary;
    }

    private function objectToObjectWithMembersAndValues(object $object): object
    {
        $dictionary = (array) $object;
        $dictionary = $this->dictionaryToDictionaryOfMembersAndValues($dictionary);
        $dictionary = [
            "members" => $dictionary["members"],
            "values" => $dictionary["values"]
        ];
        $object = (object) $dictionary;
        return $object;
    }
}
