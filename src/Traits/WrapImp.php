<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\PhpTypeJuggle;

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
    public function first()
    {
        $array = $this->arrayUnfolded();
        if (Type::is($this, ESBool::class)) {
            $array = $this->dictionaryUnfolded();

        }
        $value = array_shift($array);
        return Shoop::this($value);
    }

    public function last()
    {
        $array = [];
        $array = $this->arrayUnfolded();
        if (Type::is($this, ESBool::class)) {
            $array = $this->dictionaryUnfolded();

        }
        $value = array_pop($array);
        return Shoop::this($value);
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
                    "{$className}::start() expects an even number of value-key arguments. {$argCount} given."
                );
            }
            $prefixes = $this->indexedArrayToValueKeyArray($prefixes);
            $array = array_merge($prefixes, $array);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $prefixes = $this->indexedArrayToValueKeyArray($prefixes);
            $array = array_merge($prefixes, $array);
            $json = PhpTypeJuggle::associativeArrayToJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $prefixes = $this->indexedArrayToValueKeyArray($prefixes);
            $array = array_merge($prefixes, $array);
            $object = PhpTypeJuggle::associativeArrayToObject($array);
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
            $bool = $this->indexedArrayStartsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class, ESJson::class, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = $this->associativeArrayStartsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $starter = implode("", $needles);
            $starterLength = strlen($starter);
            $substring = substr($string, 0, $starterLength);
            $bool = $substring === $starter;
            return Shoop::bool($bool);

        }
    }

    public function endsWith(...$needles): ESBool
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $bool = $this->indexedArrayEndsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = $this->associativeArrayEndsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $bool = $this->associativeArrayEndsWith($array, $needles);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $ender = implode("", $needles);
            $enderLength = strlen($ender);
            $substring = substr($string, -$enderLength);
            $bool = $substring === $ender;
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

    private function indexedArrayStartsWith(array $array, array $needles): bool
    {
        foreach ($needles as $key => $value) {
            if ($array[$key] !== $value) {
                return false;
            }
        }
        return true;
    }

    private function indexedArrayEndsWith(array $array, array $needles): bool
    {
        $array = $this->arrayReversed($array, false);
        $needles = $this->arrayReversed($needles, false);
        $bool = $this->indexedArrayStartsWith($array, $needles);
        return $bool;
    }

    private function associativeArrayStartsWith(array $dictionary, array $needles): bool
    {
        $needles = $this->indexedArrayToValueKeyArray($needles);
        $needleCount = count($needles);

        $dictionary = array_slice($dictionary, 0, $needleCount, true);
        return $needles === $dictionary;
    }

    private function associativeArrayEndsWith(array $dictionary, array $needles): bool
    {
        $dictionary = $this->arrayReversed($dictionary, true);

        $needles = $this->indexedArrayToValueKeyArray($needles);
        $needles = $this->arrayReversed($needles, true);

        // Convert to array of value-member pairs
        $passing = [];
        foreach ($needles as $key => $value) {
            $passing[] = $value;
            $passing[] = $key;
        }

        $bool = $this->associativeArrayStartsWith($dictionary, $passing);
        return $bool;
    }

    private function objectStartsWith(object $object, array $needles): bool
    {
        $dictionary = (array) $object;
        $bool = $this->associativeArrayStartsWith($dictionary, $needles);
        return $bool;
    }

    private function objectEndsWith(object $object, array $needles): bool
    {
        $dictionary = (array) $object;
        $bool = $this->associativeArrayEndsWith($dictionary, $needles);
        return $bool;
    }
}
