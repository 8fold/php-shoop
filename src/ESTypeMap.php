<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESString;

class ESTypeMap
{
    public const TYPE_MAP = [
            "boolean" => ESBool::class,
            "integer" => ESInt::class,
            "string" => ESString::class,
            "array" => ESArray::class
            //"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
            // "object"
            // "resource"
            // "resource (closed)" as of PHP 7.2.0
            // "NULL"
            // "unknown type"
        ];

    private $isClassName = false;

    private $value;

    static public function fromClassName(string $className): ESTypeMap
    {
        return new ESTypeMap($className, true);
    }

    static public function fromValue($value): ESTypeMap
    {
        return new ESTypeMap($value);
    }

    public function __construct($value, bool $isClassName = false)
    {
        $this->isClassName = $isClassName;
        $this->value = $value;
    }

    public function className(): ESString
    {
        if ($this->isClassName) {
            return ESString::wrap($this->value);
        }

        $type = $this->phpType();
        if (array_key_exists($type, self::TYPE_MAP)) {
            return ESString::wrap(self::TYPE_MAP[$type]);
        }

        trigger_error(
            "{$this->value} is not a valid PHP or Shoop type.",
            E_USER_ERROR
        );
    }

    private function phpType(): string
    {
        return gettype($this->value);
    }

    public function phpTypeName(): ESString
    {
        return ESString::wrap($this->phpType());
    }
}
