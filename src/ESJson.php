<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    HasImp
};

use Eightfold\Shoop\ESDictionary;

// TODO: Need to be able to handle the path
class ESJson implements Shooped, Has, \JsonSerializable
{
    use ShoopedImp, HasImp;

    // TODO: How to store path ??
    protected $path = "";

// Start here
	public function __construct($initial)
	{
		if (Type::isJson($initial)) {
			$this->value = $initial;

		} else {
			trigger_error("Given string does not appear to be valid JSON: {$initial}", E_USER_ERROR);

		}
	}

// - Type Juggling
    public function string(): ESString
    {
        return Shoop::string($this->unfold());
    }

    public function array(): ESArray
    {
        return $this->dictionary()->array();
    }

    public function dictionary(): ESDictionary
    {
        $cast = (array) json_decode($this->value);
        return Shoop::dictionary($cast);
    }

    public function object(): ESObject
    {
        return $this->dictionary()->object();
    }

    public function json(): ESJson
    {
        return Shoop::json($this->unfold());
    }

// - PHP single-method interfaces
    public function __toString()
    {
        return $this->unfold();
    }

    public function jsonSerialize()
    {
        return $this->unfold();
    }

// - Math language
    public function multiply($int): ESArray
    {
        $int = Type::sanitizeType($int);
        return $this->object()->multiply($int);
    }

    public function plus(...$args): ESJson
    {
        return $this->object()->plus(...$args)->json();
    }

    public function minus(...$args): ESJson
    {
        return $this->object()->minus(...$args)->json();
    }

// - Other
    public function has($member): ESBool
    {
        return $this->hasMember($member);
    }

    public function hasMember($member): ESBool
    {
        return $this->object()->hasMember($member);
    }

    public function get($member)
    {
        $member = Type::sanitizeType($member, ESString::class)->unfold();
        $v = (array) json_decode($this->value);
        if (array_key_exists($member, $v)) {
            return Type::sanitizeType($v[$member]);
        }
        trigger_error("Undefined member on JSON.");
    }

    public function path(): ESString
    {
        return Shoop::string($this->path);
    }

    public function setPath($path): ESJson
    {
        $path = Type::sanitizeType($path, ESString::class)->unfold();
        $this->path = $path;
        return $this;
    }

// -> Array Access
    public function offsetExists($offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        return ($this->offsetExists($offset))
            ? $this->value[$offset]
            : null;
    }

    public function offsetSet($offset, $value): void
    {
        $stash = $this->value;
        if (! is_null($offset)) {
            $stash[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        $stash = $this->value;
        unset($stash[$offset]);
    }

// // //-> Iterator
//     public function current()
//     {
//         $current = key($this->value);
//         return $this->value[$current];
//     }

//     public function key()
//     {
//         return key($this->value);
//     }

//     public function next()
//     {
//         next($this->value);
//         return $this;
//     }

//     public function rewind()
//     {
//         reset($this->value);
//         return $this;
//     }

//     public function valid(): bool
//     {
//         $key = key($this->value);
//         $var = ($key !== null && $key !== false);
//         return $var;
//     }
}
