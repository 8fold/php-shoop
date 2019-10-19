<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\ESDictionary;

// TODO: Need to be able to handle the path
class ESJson implements Shooped, \JsonSerializable
{
    use ShoopedImp;

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
        $cast = (array) json_decode($this);
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
        return $this->string()->unfold();
    }

    public function jsonSerialize()
    {
        return $this->json();
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
    public function get($member)
    {
        return Type::sanitizeType($this->object()->get($member));
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
}
