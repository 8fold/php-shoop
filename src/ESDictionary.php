<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Sort,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    MathOperationsImp,
    ToggleImp,
    SortImp,
    HasImp
};

use Eightfold\Shoop\ESInt;

class ESDictionary implements
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Sort,
    Has
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, SortImp, HasImp;

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
// - PHP single-method interfaces
// - Manipulate
// - Search
// - Math language
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
// - Setters/Getters
//     public function __set(string $name, $value)
//     {
//         $name = Type::sanitizeType($name, ESString::class)->unfold();
//         $this->value->{$name} = $value;
//     }

    // public function __get(string $name)
    // {
    //     $v = (array) $this->unfold();
    //     if ($this->offsetExists($name)) {
    //         return $v[$name];
    //     }
    //     $className = static::class;
    //     trigger_error("{$className} does not define a member or index called {$name}.");
    // }

//     public function __isset(string $name): bool
//     {
//         return $this->hasMember($name)->unfold();
//     }

//     public function __unset(string $name): void
//     {
//         unset($this->value->{$name});
//     }
}
