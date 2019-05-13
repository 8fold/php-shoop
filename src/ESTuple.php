<?php

namespace Eightfold\Shoop;

class ESTuple
{
	private $values = [];

	static public function init(array $values = [])
	{
		return new ESTuple($values);
	}

	public function __construct(array $values = [])
	{
		$this->values = $values;
	}

	public function values(): array
	{
		return $this->values;
	}
}
