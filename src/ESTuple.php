<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESBool
};

class ESTuple extends ESBaseType
{
	private $values = [];

	public function __construct(...$args)
	{
        if ($this->isValidCount($args)->toggle()->unwrap()) {
            trigger_error(
                "ESTuple expects an even number of arguments wherein odd arguments are members and even arguments are values.",
                E_USER_ERROR
            );
        }

        $keys = ESArray::wrap($args)->evens()->unwrap();
        $sanitizedKeys = [];
        foreach ($keys as $key) {
            $sanitizedKeys[] = $this->sanitizeTypeOrTriggerError(
                    $key,
                    "string",
                    ESString::class
                )->unwrap();
        }
        $values = ESArray::wrap($args)->odds()->unwrap();
        $this->values = array_combine($sanitizedKeys, $values);
	}

    public function __call($name, $args)
    {
        return parent::baseTypeForValue($this->values[$name]);
    }

    private function isValidCount(array $args): ESBool
    {
        return ESBool::wrap(count($args) % 2 === 0);
    }

	public function values(): array
	{
		return $this->values;
	}
}
