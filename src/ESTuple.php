<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESBool
};

class ESTuple extends ESBaseType
{
	public function __construct(...$args)
	{
        if ($this->isValidCount($args)->toggle()->unwrap()) {
            trigger_error(
                "ESTuple expects an even number of arguments wherein odd arguments are members and even arguments are values.",
                E_USER_ERROR
            );
        }

        $sanitizedKeys = [];
        $values = [];
        foreach ($args as $index => $value) {
            if ($index === 0 || $index % 2 === 0) {
                $sanitizedKeys[] = $this->sanitizeTypeOrTriggerError(
                    $value,
                    "string",
                    ESString::class
                )->unwrap();

            } else {
                $values[] = $value;

            }
        }
        $this->value = array_combine($sanitizedKeys, $values);
	}

    private function isValidCount(array $args): ESBool
    {
        return ESBool::wrap(count($args) % 2 === 0);
    }

    public function __call($name, $args)
    {
        return parent::instanceFromValue($this->value[$name]);
    }
}
