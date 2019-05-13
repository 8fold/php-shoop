<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Equatable,
    Wrappable,
    EquatableImp
};

class ESBool implements Equatable, Wrappable
{
    use EquatableImp;

	private $value = true;

    static public function wrap(...$args)
    {
        $bool = (isset($args[0])) ? $args[0] : true;
        return static::wrapBool($bool);
    }

	static public function wrapBool(bool $bool = true): ESBool
	{
		return new ESBool($bool);
	}

//-> Random
	static public function random(): ESBool
	{
		$int = rand(1, 1000);
		return ESBool::wrap($int % 2 == 0);
	}

	public function __construct(bool $bool = true)
	{
		$this->value = $bool;
	}

    public function unwrap(): bool
    {
        return $this->value;
    }

	public function bool(): bool
	{
		return $this->value;
	}

//-> Transforming
	public function toggle(): ESBool
	{
        return ESBool::wrap(! $this->unwrap());
	}

	public function not(): ESBool
	{
		return $this->toggle();
	}

	public function or(ESBool $bool): ESBool
	{
		if ($this->bool() || $bool->bool()) {
			return ESBool::wrap();
		}
		return ESBool::wrap(false);
	}

	public function and(ESBool $bool): ESBool
	{
		if ($this->bool() && $bool->bool()) {
			return ESBool::wrap();
		}
		return ESBool::wrap(false);
	}


//-> Describing
	/**
	 * TODO: return String class - no literal
	 * @return [type] [description]
	 */
	public function description(): string
	{
		return ($this->value) ? "true" : "false";
	}
}
