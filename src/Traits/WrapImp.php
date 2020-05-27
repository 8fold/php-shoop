<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpAssociativeArray,
    PhpString
};

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

trait WrapImp
{
    public function first($count = 1)
    {
        $count = Type::sanitizeType($count, ESInt::class)->unfold();
        $array = $this->array()->unfold();
        if (Type::is($this, ESBool::class)) {
            $array = $this->dictionary()->unfolded();

        }

        if ($count === 1) {
            $value = array_shift($array);
            return Shoop::this($value);
        }

        $result = Shoop::int(1)->range($count)->each(function($int) use (&$array) {
            // TODO: Consider using splitAt or array_slice
            $value = array_shift($array);
            return Shoop::this($value);
        });

        if (Type::is($this, ESString::class)) {
            return $result->join("");
        }
        return $result;
    }

    public function last($count = 1)
    {
        $count = Type::sanitizeType($count, ESInt::class)->unfold();
        $array = $this->arrayUnfolded();
        if (Type::is($this, ESBool::class)) {
            $array = $this->dictionaryUnfolded();

        }

        if ($count === 1) {
            $value = array_pop($array);
            return Shoop::this($value);
        }

        $result = Shoop::int(1)->range($count)->each(function($int) use (&$array) {
            // TODO: Consider using splitAt or array_slice
            $value = array_pop($array);
            return Shoop::this($value);
        })->toggle(false);

        if (Type::is($this, ESString::class)) {
            return $result->join("");
        }
        return $result;
    }

    public function start(...$prefixes)
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = array_merge($prefixes, $array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            if ($this->argCountIsOdd($prefixes)) {
                $className = static::class;
                $argCount = count($prefixes);
                trigger_error(
                    "{$className}::start() expects an even number of value-member arguments. {$argCount} given."
                );
            }
            $prefixes = PhpIndexedArray::toValueMemberAssociativeArray($prefixes);
            $array = array_merge($prefixes, $array);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $prefixes = PhpIndexedArray::toValueMemberAssociativeArray($prefixes);
            $array = array_merge($prefixes, $array);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $prefixes = PhpIndexedArray::toValueMemberAssociativeArray($prefixes);
            $array = array_merge($prefixes, $array);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $prefix = implode("", $prefixes);
            $string = $prefix . $string;
            return Shoop::string($string);

        }
    }

    public function end(...$suffixes)
    {
        return $this->plus(...$suffixes);
    }

    public function startsWith(...$needles): ESBool
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $bool = PhpIndexedArray::startsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class, ESJson::class, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = PhpAssociativeArray::startsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $starter = implode("", $needles);
            $bool = PhpString::startsWith($string, $starter);
            return Shoop::bool($bool);

        }
    }

    public function endsWith(...$needles): ESBool
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $bool = PhpIndexedArray::endsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = PhpAssociativeArray::endsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = PhpAssociativeArray::endsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $ender = implode("", $needles);
            $bool = PhpString::endsWith($string, $ender);
            return Shoop::bool($bool);

        }
    }

    public function doesNotStartWith(...$needles): ESBool
    {
        return $this->startsWith(...$needles)->toggle();
    }

    public function doesNotEndWith(...$needles): ESBool
    {
        return $this->endsWith(...$needles)->toggle();
    }
}
