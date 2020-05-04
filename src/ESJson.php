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

class ESJson implements Shooped, Compare, MathOperations, Wrap, Drop, Has, IsIn, \JsonSerializable
{
    use ShoopedImp, CompareImp, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp;

    /**
     * @todo Need a solution for the path
     */
    protected $path = "";

	public function __construct($initial)
	{
		if (Type::isJson($initial)) {
			$this->value = $initial;

		} else {
			trigger_error("Given string does not appear to be valid JSON: {$initial}", E_USER_ERROR);

		}
	}

    public function jsonSerialize()
    {
        return $this->value;
    }
}
