<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

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
        return $this->int();
    }

    public function plus(...$args) // self
    {
        if (Type::is($this, ESArray::class)) {
            $count = count($args);
            if ($count === 0) {
                return static::fold($this->value);
            }
            $merged = array_merge($this->value, $args);
            return Shoop::array($merged);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->indexedArrayToValueKeyArray($args);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $total = $this->value;
            foreach ($args as $term) {
                $term = Type::sanitizeType($term, ESInt::class)->unfold();
                $total += $term;
            }
            return Shoop::int($total);

        } elseif (Type::is($this, ESJson::class)) {
            $dictionary = $this->indexedArrayToValueKeyArray($args);
            $object = json_decode($this->value);
            foreach ($dictionary as $key => $value) {
                $object->{$key} = $value;
            }
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $dictionary = $this->indexedArrayToValueKeyArray($args);
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
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            // TODO: In case values are Shooped types
            // if (Type::isNotArray($args)) {
            //     $args = [$args];
            // }
            // $deletes = Type::sanitizeType($args, ESArray::class)->unfold();
            $deletes = $args;
            $copy = $this->value;
            $array = array_filter($copy, function($index) use ($deletes) {
                return ! in_array($index, $deletes);
            }, ARRAY_FILTER_USE_KEY);
            $array = array_values($array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESInt::class)) {
            $total = $this->value;
            foreach ($args as $term) {
                $term = Type::sanitizeType($term, ESInt::class)->unfold();
                $total -= $term;
            }
            return ESInt::fold($total);

        } elseif (Type::is($this, ESJson::class)) {
            $object = json_decode($this->value);
            foreach ($args as $member) {
                if (method_exists($object, $member) or property_exists($object, $member)) {
                    unset($object->{$member});
                }
            }
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            foreach ($args as $member) {
                if (method_exists($object, $member) or property_exists($object, $member)) {
                    unset($object->{$member});
                }
            }
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            return Shoop::string(str_replace($args, "", $this->unfold()));

        }
    }

    public function multiply($int = 1)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

    private function indexedArrayToValueKeyArray(array $args): array
    {
        $count = count($args);
        if ($count % 2 !== 0) {
            $className = ESDictionary::class;
            trigger_error(
                "{$className}::plus() expects two (or more) arguments. {$count->unfold()} given."
            );
        }

        $count = 0;
        $keys = [];
        $values = [];
        foreach ($args as $value) {
            if ($count === 0 or $count % 2 === 0) {
                $values[] = $value;

            } else {
                $keys[] = $value;

            }
            $count++;
        }
        $dictionary = array_combine($keys, $values);
        return $dictionary;
    }
}
