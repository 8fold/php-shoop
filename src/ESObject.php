<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\Helpers\Type;

class ESObject implements Shooped
{
    use ShoopedImp;

    public function __construct($object)
    {
        if (is_object($object)) {
            $this->value = $object;

        } elseif (is_a($object, ESObject::class)) {
            $this->value = $object->unfold();

        } else {
            $this->value = new \stdClass();

        }
    }

// - Type Juggling
    public function string(): ESString
    {
        return $this->dictionary()->string();
    }

    public function array(): ESArray
    {
        $array = (array) $this->value;
        return Shoop::dictionary($array)->array();
    }

    // TODO: ?? This could be a truly universal implementation
    public function bool(): ESBool
    {
        return Type::isEmpty($this->array())->toggle();
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true): ESObject
    {
        return $this->dictionary()
            ->toggle()
            ->object();
    }

    public function shuffle()
    {
        $array = (array) $this->unfold();
        shuffle($array);
        $object = (object) $array;
        return Shoop::object($object);
    }

    public function sort($caseSensitive = true): ESObject
    {
        return $this->dictionary()->sort($caseSensitive)->object();
    }

    public function start(...$prefixes)
    {
        return $this->plus(...$prefixes);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            if ($this->has($val)->toggleUnfolded()) {
                return Shoop::bool(false);
            }
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        return $this->startsWith($needle);
    }

// - Math language
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

    public function plus(...$args)
    {
        if (Shoop::array($args)->count()->isNotUnfolded(2)) {
            $className = ESObject::class;
            $count = Shoop::array($args)->count();
            trigger_error(
                "{$className}::plus() expects two arguments. {$count} given."
            );
        }

        $key = Type::sanitizeType($args[0], ESString::class)->unfold();
        $this->{$key} = $args[1];
        return Shoop::object($this->unfold());
    }

    public function minus(...$args): ESObject
    {
        $stash = (array) $this->value;
        foreach ($args as $delete) {
            $member = Type::sanitizeType($delete, ESString::class)->unfold();
            unset($stash[$member]);
        }
        return Shoop::object((object) $stash);
    }

    public function divide($value = null)
    {
        return $this->dictionary()
            ->divide()
            ->object()
            ->rename("keys", "members");
    }

    private function rename(string $member, string $new)
    {
        $value = $this->{$member};
        $this->{$new} = $value;
        unset($this->{$member});
        return $this;
    }

// - Setters/Getters
    public function __set($name, $value)
    {
        $name = Type::sanitizeType($name, ESString::class)->unfold();
        $this->value->{$name} = $value;
    }

    public function __get (string $name)
    {
        if (isset($this->value->{$name})) {
            return $this->value->{$name};
        }
        return null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->value->{$name});
    }

    public function __unset(string $name)
    {
        unset($this->value->{$name});
    }
}
