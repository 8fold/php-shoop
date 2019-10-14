<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

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

    public function array(): ESArray
    {
        $array = (array) $this->value;
        return Shoop::dictionary($array)->enumerate();
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

    // TODO: ?? This could be a truly universal implementation
    public function bool(): ESBool
    {
        return Shoop::array((array) $this->unfold())
            ->isGreaterThan(0);
    }

    public function __toString()
    {
        $array = (array) $this->unfold();
        return (string) Shoop::dictionary($array);
    }

// TODO: Tests!!!!!!
//  Really starting to reconsider...
    public function toggle()
    {
        return $this->dictionary()
            ->toggle()
            ->objectUnfolded();
    }

    public function sort()
    {
        $array = $this->unfold();
        natsort($array);
        $object = (object) $array;
        return Shoop::object($object);
    }

    public function shuffle()
    {
        $array = $this->unfold();
        shuffle($array);
        $object = (object) $array;
        return Shoop::object($object);
    }

    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            if ($this->contains($val)->toggleUnfolded()) {
                return Shoop::bool(false);
            }
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        return $this->startsWith($needle);
    }

    public function start(...$prefixes)
    {
        return $this->plus(...$prefixes);
    }

    // TODO: Test
    public function divide($value = null)
    {
        $initial = Shoop::dictionary($this->unfold())->divide();
        return Shoop::dictionary(["properties" => $initial["keys"], "values" => $initial["values"]]);
    }

    public function minus($value)
    {
        $key = Type::sanitizeType($value, ESString::class);
        unset($this->{$key});
        return Shoop::object($this->unfold());
    }

    public function plus(...$args)
    {
        // TODO: Need to figure out more about how stdClass works re adding props
        if (Shoop::array($args)->count()->isNotUnfolded(2)) {
            $className = ESDictionary::class;
            $count = Shoop::array($args)->count();
            trigger_error(
                "{$className}::plus() expects two arguments. {$count} given."
            );
        }

        $key = $this->sanitizeType($args[0], ESString::class)->unfold();

        $dict = $this->unfold();
        $dict[$key] = $args[1];
        return Shoop::dictionary($dict);
    }

    // Todo: Test
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = Shoop::array([]);
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return $array;
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
