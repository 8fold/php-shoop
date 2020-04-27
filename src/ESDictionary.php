<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Countable,
    Toggle,
    Sort,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    ToggleImp,
    SortImp,
    HasImp
};

use Eightfold\Shoop\ESInt;

// TODO: get($key) - ESArray, ESDictionary
class ESDictionary implements
    \Iterator,
    Shooped,
    Countable,
    Toggle,
    Sort,
    Has
{
    use ShoopedImp, CountableImp, ToggleImp, SortImp, HasImp;

    public function __construct($dictionary)
    {
        if (is_array($dictionary) && Type::isDictionary($dictionary)) {
            $this->value = $dictionary;

        } elseif (is_a($dictionary, ESDictionary::class)) {
            $this->value = $dictionary->unfold();

        } else {
            $this->value = [];

        }
    }

// - Type Juggling
    public function array(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    public function dictionary(): ESDictionary
    {
        return Shoop::dictionary($this->unfold());
    }

    public function json(): ESJson
    {
        return Shoop::json(json_encode($this->unfold()));
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true)
    {
        // TODO: What should happen if members aren't preserved?
        $array = array_flip($this->unfold());
        if (Type::isNotDictionary($array) && Type::isArray($array)) {
            return Shoop::array($array);

        }
        return static::fold($array);
    }

// - Search
// - Math language
    public function plus(...$args)
    {
        $count = count($args);// Shoop::array($args)->count();
        if ($count < 2) {
        // if ($count->isLessThanUnfolded(2)) {
            $className = ESObject::class;
            trigger_error(
                "{$className}::plus() expects two arguments. {$count->unfold()} given."
            );
        }

        $key = Type::sanitizeType($args[0], ESString::class)->unfold();
        $value = $args[1];
        $overwrite = true;
        if ($count === 3 && $args[2] !== null && Type::is($args[2], ESBool::class, "bool")) {
            $overwrite = Type::sanitizeType($args[2], ESBool::class)->unfold();
        }
        return $this->set($value, $key, $overwrite);
    }

    public function minus(...$args): ESDictionary
    {
        $stash = $this->value;
        foreach ($args as $delete) {
            $member = Type::sanitizeType($delete, ESString::class)->unfold();
            unset($stash[$member]);
        }
        return Shoop::dictionary($stash);
    }

    public function divide($value = null)
    {
        $keys = $this->members();
        $values = $this->array();
        return Shoop::dictionary(["keys" => $keys, "values" => $values]);
    }

// - Comparison
// - Other
    public function set($value, $key, $overwrite = true)
    {
        $key = Type::sanitizeType($key, ESString::class)->unfold();
        $overwrite = Type::sanitizeType($overwrite, ESBool::class)->unfold();

        $cast = (array) $this->value;
        if (! $overwrite && $this->hasMember($key)) {
            $currentValue = $cast[$key];
            if (is_array($currentValue)) {
                $currentValue[] = $value;

            } else {
                $currentValue = [$currentValue, $value];

            }

            $cast[$key] = $currentValue;
            return static::fold($cast);
        }
        $merged = array_merge($cast, [$key => $value]);
        return static::fold($merged);
    }

    public function get($key)
    {
        $key = Type::sanitizeType($key, ESString::class)->unfold();
        if ($this->hasMember($key)) {
            $value = $this->value[$key];
            if (Type::isPhp($value)) {
                return Type::sanitizeType($value);
            }
            return $value;
        }
        trigger_error("Undefined index or member.");
    }

    // TODO: Promote to ShoopedImp, with custom for ESString
    public function hasMember($member): ESBool
    {
        $member = Type::sanitizeType($member, ESString::class)->unfold();
        return Shoop::bool($this->offsetExists($member));
    }

    private function members(): ESArray
    {
        return Shoop::array(array_keys($this->value));
    }

    public function each(\Closure $closure): ESArray
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $consider = $closure($value, $key);
            if ($consider !== null) {
                $build[] = $consider;
            }
        }
        return Shoop::array($build);
    }
// - Transforms
// - Callers
//     public function __call($name, $args = [])
//     {
//         $name = Shoop::string($name)->unfold();
//         if (substr($name, 0, strlen("set")) === "set") {
//             return $this->handleSet($name, $args);

//         } elseif (substr($name, -(strlen("Unfolded"))) === "Unfolded") {
//             $name = str_replace("Unfolded", "", $name);
//             return $this->handleGetUnfolded($name, $args);

//         } else {
//             $value = $this->get($name);
//             $return = (isset($value) && Type::isShooped($value))
//                 ? $value->unfold()
//                 : $value;
//             return $return;
//         }
//     }

//     private function handleSet($name, $args)
//     {
//         $name = lcfirst(str_replace("set", "", $name));
//         $overwrite = (isset($args[1])) ? $args[1] : true;
//         $value = (isset($args[0])) ? $args[0] : null;

//         return $this->set($name, $value, $overwrite);
//     }

//     private function handleGetUnfolded($name, $args)
//     {
//         $value;
//         if (! method_exists($this, $name)) {
//             $className = static::class;
//             trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);

//         } elseif ($name === "plus" || $name === "minus") {
//             $value = $this->{$name}(...$args);

//         } else {
//             $value = $this->{$name}($args[0]);

//         }
//         return (Type::isShooped($value)) ? $value->unfold() : $value;
//     }

// // - Setters/Getters
//     public function __set(string $name, $value)
//     {
//         $name = Type::sanitizeType($name, ESString::class)->unfold();
//         $this->value->{$name} = $value;
//     }

    public function __get(string $name)
    {
        $v = (array) $this->unfold();
        if ($this->offsetExists($name)) {
            return $v[$name];
        }
        $className = static::class;
        trigger_error("{$className} does not define a member or index called {$name}.");
    }

//     public function __isset(string $name): bool
//     {
//         return $this->hasMember($name)->unfold();
//     }

//     public function __unset(string $name): void
//     {
//         unset($this->value->{$name});
//     }

// -> Array Access
    // public function offsetUnset($offset): void {}
    // public function offsetExists($offset): bool
    // {
    //     return $this->members()->has($offset)->unfold();
    // }

    // public function offsetGet($offset)
    // {
    //     // TODO: Create null class ??
    //     if ($this->get($offset) === null) {
    //         return null;
    //     }
    //     return $this->get($offset);
    // }

    // public function offsetSet($offset, $value): ESObject
    // {
    //     // return $this->set($offset, $value);
    // }

    // public function offsetUnset($offset): void
    // {
    //     // $this->__unset($offset);
    // }

// //-> Iterator
//     private $tempDict;

//     /**
//      * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
//      *
//      * Same implementation for Object, Dictionary, JSON
//      *
//      * @return [type] [description]
//      */
//     public function rewind()
//     {
//         $this->tempDict = $this->dictionary()->unfold();
//     }

//     public function valid(): bool
//     {
//         if (! isset($this->tempDict)) {
//             $this->rewind();
//         }
//         return $this->hasMemberUnfolded(key($this->tempDict));
//     }

//     public function current()
//     {
//         if (! isset($this->tempDict)) {
//             $this->rewind();
//         }
//         $dict = $this->tempDict;
//         $key = key($dict);
//         return $dict[$key];
//     }

//     public function key()
//     {
//         if (! isset($this->tempDict)) {
//             $this->rewind();
//         }
//         $dict = $this->tempDict;
//         $key = key($dict);
//         if (is_int($key)) {
//             return Type::sanitizeType($key, ESInt::class, "int")->unfold();
//         }
//         return Type::sanitizeType($key, ESString::class, "string")->unfold();
//     }

//     public function next()
//     {
//         if (! isset($this->tempDict)) {
//             $this->rewind();
//         }
//         next($this->tempDict);
//     }
}
