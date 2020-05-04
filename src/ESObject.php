<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Sort,
    Toggle,
    Wrap,
    Drop,
    Has,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    MathOperationsImp,
    SortImp,
    ToggleImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp
};

class ESObject implements Shooped, Compare, MathOperations, Sort, Toggle, Wrap, Drop, Has, IsIn
{
    use ShoopedImp, CompareImp, MathOperationsImp, SortImp, ToggleImp, WrapImp, DropImp, HasImp, IsInImp;

    public function __construct($object)
    {
        if (is_object($object)) {
            $this->value = $object;

        } elseif (is_a($object, ESObject::class)) {
            $this->value = $object->unfold();

        } elseif (Type::is($object, ESArray::class, ESDictionary::class)) {
            $this->value = (object) $object->unfold();

        } elseif (is_array($object)) {
            $this->value = (object) $object;

        } else {
            $this->value = new \stdClass();

        }
    }

// - Transforms
// - Callers
    // public function __call($name, $args = [])
    // {
    //     $name = Shoop::string($name);
    //     if ($name->startsWith("set")->unfold()) {
    //         $member = $name->minus("set")->lowerFirst();
    //         $overwrite = (isset($args[1])) ? $args[1] : true;
    //         $value = (isset($args[0])) ? $args[0] : null;

    //         return $this->set($member, $value, $overwrite);

    //     } elseif ($name->endsWith("Unfolded")->unfold()) {
    //         $member = $name->minus("Unfolded");
    //         if (method_exists($this, $member)) {
    //             $value = $this->{$member->unfold()}($args);
    //             if (Type::isShooped($value)) {
    //                 return $value->unfold();
    //             }
    //         }
    //         $value = $this->get($member);
    //         $return = (isset($value) && Type::isShooped($value))
    //             ? $value->unfold()
    //             : $value;
    //         return $return;

    //     } else {
    //         return Type::sanitizeType($this->get($name->minus("get")->lowerFirst()));

    //     }
    // }

// - Setters/Getters
    // public function __set(string $name, $value)
    // {
    //     $name = Type::sanitizeType($name, ESString::class)->unfold();
    //     $this->value->{$name} = $value;
    // }

    // public function __get (string $name)
    // {
    //     if ($this->hasMember($name)->unfold()) {
    //         return $this->value->{$name};
    //     }
    //     return null;
    // }

    // public function __isset(string $name): bool
    // {
    //     return $this->hasMember($name)->unfold();
    // }

    // public function __unset(string $name): void
    // {
    //     unset($this->value->{$name});
    // }

// -> Array Access
}
