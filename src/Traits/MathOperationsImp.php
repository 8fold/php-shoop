<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpAssociativeArray, // TODO: Use facade
    PhpObject
};

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
            // TODO: Pretty sure this should be the same expections as set()
            $dictionary = $this->value;
            $suffixes = PhpIndexedArray::toValueMemberAssociativeArray($args);
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
            // TODO: Pretty sure this should be the same expectations as set()
            $dictionary = PhpIndexedArray::toValueMemberAssociativeArray($args);
            $object = json_decode($this->value);
            foreach ($dictionary as $member => $value) {
                $object->{$member} = $value;
            }
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            // TODO: Pretty sure this should be the same expectations as set()
            //      or that set, should use plus()
            $dictionary = PhpIndexedArray::toValueMemberAssociativeArray($args);
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
            $object = PhpObject::afterRemovingMembers($object, $args);
            $json = PhpObject::toJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            $object = PhpObject::afterRemovingMembers($object, $args);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            return Shoop::string(str_replace($args, "", $this->unfold()));

        }
    }

    public function divide($divisor = 0, $includeEmpties = true, $limit = PHP_INT_MAX)
    {
        if (Type::is($this, ESArray::class)) {
            $divisor = Type::sanitizeType($divisor, ESInt::class)->unfold();
            $lhs = array_slice($this->value(), 0, $divisor);
            $rhs = array_slice($this->value(), $divisor);
            if ( ! $includeEmpties) {
                $lhs = Shoop::array($lhs)->noEmpties()->reindexUnfolded();
                $rhs = Shoop::array($rhs)->noEmpties()->reindexUnfolded();
            }
            return Shoop::array([$lhs, $rhs]);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->dictionaryUnfolded();
            if ( ! $includeEmpties) {
                $dictionary = $this->dictionary()->noEmptiesUnfolded();
            }
            $dictionary = PhpAssociativeArray::toMembersAndValuesAssociativeArray($dictionary);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->intUnfolded();
            $divisor = Type::sanitizeType($divisor, ESInt::class)->unfold();
            $int = (int) round($int/$divisor);
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            if ( ! $includeEmpties) {
                $object = $this->dictionary()->noEmpties()->objectUnfolded();
            }
            $object = PhpObject::toMembersAndValuesAssociativeArray($object);
            $json = PhpObject::toJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            if ( ! $includeEmpties) {
                $object = $this->dictionary()->noEmpties()->objectUnfolded();
            }
            $object = PhpObject::toMembersAndValuesAssociativeArray($object);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $array = explode($divisor, $string, $limit);
            $array = Shoop::array($array);
            if (! $includeEmpties) {
                $array = $array->noEmpties();
            }
            return $array;

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
}
