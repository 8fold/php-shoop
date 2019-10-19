<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Countable,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    HasImp
};

use Eightfold\Shoop\Helpers\Type;

class ESObject implements Shooped, Countable, Has
{
    use ShoopedImp, CountableImp, HasImp;

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

    public function dictionary(): ESDictionary
    {
        $array = (array) $this->unfold();
        return Shoop::dictionary($array);
    }

    public function object(): ESObject
    {
        return Shoop::object($this->unfold());
    }

    public function bool(): ESBool
    {
        return Type::isEmpty($this->array())->toggle();
    }

    public function json(): ESJson
    {
        return Shoop::json(json_encode($this->unfold()));
    }

// - PHP single-method interfaces
// - Manipulate
// - Search
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
        $className = ESObject::class;
        $count = Shoop::array($args)->count();
        if ($count->isNotUnfolded(2)) {
            trigger_error(
                "{$className}::plus() expects two arguments. {$count->unfold()} given."
            );
        }

        $key = Type::sanitizeType($args[0], ESString::class)->unfold();
        $this->value->{$key} = $args[1];
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

    public function get($member)
    {
        return Type::sanitizeType($this->unfold()->{$member});
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
