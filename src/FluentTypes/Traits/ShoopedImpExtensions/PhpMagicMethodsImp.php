<?php

namespace Eightfold\Shoop\Traits\ShoopedImpExtensions;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpIndexedArray,
    PhpBool,
    PhpAssociativeArray,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

trait PhpMagicMethodsImp
{
     public function __call(string $name, array $args = [])
    {
        $remove = [];
        if (PhpString::startsAndEndsWith($name, "get", "Unfolded")) {
            $remove = ["get", "Unfolded"];

        } elseif (PhpString::startsWithSet($name)) {
            $remove = ["set"];

        } elseif (PhpString::startsWithGet($name)) {
            $remove = ["get"];

        } elseif (PhpString::endsWithUnfolded($name)) {
            $remove = ["Unfolded"];

        }

        $cName = $name;
        if (count($remove) > 0) {
            $cName = PhpString::afterRemoving($name, $remove);
            $cName = lcfirst($cName);
        }

        $value;
        if (PhpString::startsWithSet($name)) {
            $value = (isset($args[0])) ? $args[0] : null;
            $overwrite = (isset($args[1])) ? $args[1] : true;
            $value = $this->set($value, $cName, $overwrite);

        } elseif ($this->isGetter($name) and method_exists($this, $cName)) {
            $value = $this->{$cName}(...$args);

        } elseif ($this->offsetExists($cName)) {
            $value = $this->get($cName);

        } elseif ($this->isGetter($name)) {
            $value = Shoop::this($this->{$cName});

        }

        return (Type::isShooped($value) and $this->needsUnfolding($name))
            ? $value->unfold()
            : $value;
    }

    public function __get($name)
    {
        $value = null;
        if (method_exists($this, $name)) {
            $value = $this->{$name}();

        } elseif ($this->offsetExists($name)) {
            $value = $this->offsetGet($name);

        }
        return (Type::isFoldable($value)) ? $value->unfold() : $value;
    }

    private function needsUnfolding($name): bool
    {
        return PhpString::startsAndEndsWith($name, "get", "Unfolded") or
            PhpString::endsWithUnfolded($name);
    }

// - Getters/Setters
    public function get($member = 0)
    {
        if (Type::is($this, ESArray::class, ESInt::class, ESString::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();

        } elseif (Type::is($this, ESDictionary::class, ESJson::class, ESObject::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();

        }

        $array = Shoop::array([]);

        if (Type::is($this, ESArray::class, ESDictionary::class) and $this->offsetExists($member)) {
            return Shoop::this($this->offsetGet($member)); // The only return of consequence

        } elseif (Type::is($this, ESBool::class)) {
            $array = $this->dictionary();
            if (Type::isInt($member)) {
                $array = $array->array();
            }

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpInt::toIndexedArray($this->main());

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpString::toIndexedArray($this->main());

        }
        return Shoop::this($array)->get($member);
    }

    public function getUnfolded($name)
    {
        $value = $this->get($name);
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

    public function set($value, $member = null, $overwrite = true): Foldable
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->main();
            $array = (Type::is($this, ESArray::class))
                ? PhpIndexedArray::afterSettingValue($array, $value, $member, $overwrite)
                : PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
            return (Type::is($this, ESArray::class))
                ? Shoop::array($array)
                : Shoop::dictionary($array);

        } elseif (Type::is($this, ESBool::class, ESString::class)) {
            $v = $this->main();
            $v = (Type::is($this, ESBool::class))
                ? Type::sanitizeType($value, ESBool::class)->unfold()
                : Type::sanitizeType($value, ESString::class)->unfold();
            return (Type::is($this, ESBool::class))
                ? Shoop::bool($v)
                : Shoop::string($v);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->main();
            $int = Type::sanitizeType($value, ESInt::class)->unfold();
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->main();
            $array = PhpJson::toAssociativeArray($json);
            $array = PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->main();
            $array = PhpObject::toAssociativeArray($object);
            $array = PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);
        }
    }

    private function isGetter(string $name): bool
    {
        return PhpString::startsAndEndsWith($name, "get", "Unfolded") or
            PhpString::startsWithGet($name) or
            (! method_exists($this, $name) and ! PhpString::startsWithGet($name));
    }

    public function __toString(): string
    {
        return $this->string()->unfold();
    }

    // TODO: Can this be improved somehow??
    public function __debugInfo(): array
    {
        return [
            "main" => $this->main(),
            "args" => $this->args()
        ];
    }
}
