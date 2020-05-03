<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

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

use Eightfold\Shoop\ESDictionary;

// TODO: Need to be able to handle the path
class ESJson implements Shooped, Compare, MathOperations, Wrap, Drop, Has, IsIn, \JsonSerializable
{
    use ShoopedImp, CompareImp, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp;

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
// - Comparison
// - PHP single-method interfaces
    public function jsonSerialize()
    {
        return $this->value;
    }

// - Math language
// - Other
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
}
