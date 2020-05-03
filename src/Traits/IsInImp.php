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

trait IsInImp
{
    public function isIn($haystack): ESBool
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $haystack = Type::sanitizeType($haystack, ESArray::class)->unfold();
            $array = $this->value;
            $bool = in_array($array, $haystack);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESBool::class)) {
            $haystack = Type::sanitizeType($haystack, ESArray::class)->unfold();
            $bool = $this->value;
            $bool = in_array($bool, $haystack);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESInt::class)) {
            $haystack = Type::sanitizeType($haystack, ESArray::class)->unfold();
            $int = $this->value;
            $bool = in_array($int, $haystack);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESJson::class)) {
            $haystack = Type::sanitizeType($haystack, ESArray::class)->unfold();
            $json = $this->value;
            $bool = in_array($json, $haystack);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESObject::class)) {
            $haystack = Type::sanitizeType($haystack, ESArray::class)->unfold();
            $object = $this->value;
            $bool = in_array($object, $haystack);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $haystack = Type::sanitizeType($haystack, ESString::class)->unfold();
            $string = $this->value;
            $bool = strpos($haystack, $string) !== false;
            return Shoop::bool($bool);

        }
    }
}
