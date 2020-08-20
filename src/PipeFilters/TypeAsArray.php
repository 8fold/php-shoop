<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;
use Eightfold\Shoop\PipeFilters\TypeOf;

class TypeAs extends Filter
{
    private $targetType = "boolean";
    private $secondary  = 0;
    private $tertiary   = false;
    private $quaternary = PHP_INT_MAX;
    private $quinary    = "";

    public function __construct(
        string $targetType = "boolean",
        $secondary         = 0, // TODO: PHP 8.0 - int|string
        bool $tertiary     = false,
        int $quaternary    = PHP_INT_MAX,
        string $quinary    = "i"
    )
    {
        $this->targetType = $targetType;
        $this->secondary  = $secondary;
        $this->tertiary   = $tertiary;
        $this->quaternary = $quaternary;
        $this->quinary    = $quinary;
    }

    public function __invoke($using)
    {
        // Make individual callables
        // TypeAsBoolean
        // TypeAsInteger
        // TypeAsNumber
        // TypeAsString
        // TypeAsArray
        // TypeAsDictionary
        // TypeAsTuple
        // TypeAsJson
        // TypeAsObject - won't be implemented
        $type = TypeOf::apply()->unfoldUsing($using);
        $target = $this->targetType;
        if (TypeIs::applyWith($target)->unfoldUsing($using)) {
            if (TypeIs::applyWith("json")->unfoldUsing($using)) {
                $using = json_decode($using);
            }
            return $using;

        } elseif (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            if ($target === "integer") {
                return $this->booleanToInteger($using);

            } elseif ($target === "float") {
                return $this->booleanToFloat($using);

            } elseif ($target === "array") {
                return $this->booleanToArray($using);

            } elseif ($target === "dictionary") {
                return $this->booleanToDictionary($using);

            } elseif ($target === "tuple") {
                return $this->booleanToTuple($using);

            } elseif ($target === "json") {
                return $this->booleanToJson($using);

            }

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            if ($target === "boolean") {
                return $this->numberToBoolean($using);

            } elseif ($target === "array") {
                return $this->numberToArray($using, $this->secondary);

            } elseif ($target === "dictionary") {
                return $this->numberToDictionary($using, $this->secondary);

            } elseif ($target === "tuple") {
                return $this->numberToTuple($using);

            } elseif ($target === "json") {
                return $this->numberToJson($using);

            }

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            if (is_int($this->secondary)) {
                $this->secondary = "";
            }

            if ($target === "boolean") {
                return $this->stringToBoolean($using);

            } elseif ($target === "integer") {
                return $this->stringToInteger($using);

            } elseif ($target === "array") {
                return $this->stringToArray($using,
                    $this->secondary,
                    $this->tertiary,
                    $this->quaternary
                );

            } elseif ($target === "dictionary") {
                return $this->stringToDictionary($using,
                    $this->secondary,
                    $this->tertiary,
                    $this->quaternary,
                    $this->quinary
                );

            } elseif ($target === "tuple") {
                return $this->stringToTuple($using,
                    $this->secondary,
                    $this->tertiary,
                    $this->quaternary,
                    $this->quinary
                );

            } elseif ($target === "json") {
                return $this->stringToJson($using,
                    $this->secondary,
                    $this->tertiary,
                    $this->quaternary,
                    $this->quinary
                );

            }

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if ($target === "boolean") {
                return $this->listToBoolean($using);

            } elseif ($target === "integer") {
                return $this->listToInteger($using);

            } elseif ($target === "float") {
                return $this->listToFloat($using);

            } elseif ($target === "array") {
                return $this->listToArray($using);

            } elseif ($target === "dictionary") {
                if (is_int($this->secondary)) {
                    $this->secondary = "i";
                }
                return $this->listToDictionary($using, $this->secondary);

            } elseif ($target === "string") {
                if (is_int($this->secondary)) {
                    $this->secondary = "";
                }
                return $this->listToString($using, $this->secondary);

            } elseif ($target === "tuple") {
                if (is_int($this->secondary)) {
                    $this->secondary = "i";
                }
                return $this->listToTuple($using, $this->secondary);

            } elseif ($target === "json") {
                return $this->listToJson($using, $this->secondary);

            }

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (TypeIs::applyWith("json")->unfoldUsing($using)) {
                $using = json_decode($using);
            }

            if ($target === "boolean") {
                return $this->tupleToBoolean($using);

            } elseif ($target === "integer") {
                return $this->tupleToInteger($using);

            } elseif ($target === "float") {
                return $this->tupleToFloat($using);

            } elseif ($target === "array") {
                return $this->tupleToArray($using);

            } elseif ($target === "dictionary") {
                return $this->tupleToDictionary($using);

            } elseif ($target === "json") {
                return $this->tupleToJson($using);

            }

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if ($target === "boolean") {
                return $this->objectToBoolean($using);

            } elseif ($target === "integer") {
                return $this->objectToInteger($using);

            } elseif ($target === "float") {
                return $this->objectToFloat($using);

            } elseif ($target === "array") {
                return $this->objectToArray($using);

            } elseif ($target === "dictionary") {
                return $this->objectToDictionary($using);

            } elseif ($target === "tuple") {
                return $this->objectToTuple($using);

            }
        }
    }

    private function booleanToInteger(bool $using): int
    {
        return (int) $using;
    }

    private function booleanToFloat(bool $using): float
    {
        return (float) $using;
    }

    private function booleanToArray(bool $using): array
    {
        return [$using];
    }

    private function booleanToDictionary(bool $using): array
    {
        return ($using)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }

    private function booleanToTuple(bool $using): object
    {
        return (object) $this->booleanToDictionary($using);
    }

    private function booleanToJson(bool $using): string
    {
        $tuple = $this->booleanToTuple($using);
        return static::tupleToJson($tuple);
    }

    // TODO: PHP 8.0 int|float
    private function numberToBoolean($using): bool
    {
        // delete when type safety can be increased
        if (! is_float($using) and ! is_int($using)) {
            return false;
        }
        return (bool) $using;
    }

    // TODO: PHP 8.0 - int|float
    static public function numberToInteger($using)
    {
        return (int) $using;
    }

    // TODO: PHP 8.0 - int|float
    static public function numberToArray($using, int $start = 0): array
    {
        // delete when type safety can be increased
        if (! is_float($using) and ! is_int($using)) {
            return [];
        }
        $int = (int) $using;
        return range($start, $int);
    }

    // TODO: PHP 8.0 - int|float
    private function numberToDictionary(
        $using,
        int $start,
        string $prefix = "i"
    ): array
    {
        // delete when type safety can be increased
        if (! is_float($using) and ! is_int($using)) {
            return [];
        }
        $int = (int) $using;
        $array = $this->numberToArray($using, 0);
        return $this->listToDictionary($array, $prefix);
    }

    // TODO: PHP 8.0 - int|float
    private function numberToTuple($using): object
    {
        // delete when type safety can be increased
        if (! is_float($using) and ! is_int($using)) {
            return (object) [];
        }
        $dictionary = TypeAs::applyWith("dictionary")
            ->unfoldUsing($using);
        return (object) $dictionary;
    }

    // TODO: PHP 8.0 - int|float
    private function numberToJson($using): string
    {
        // delete when type safety can be increased
        $tuple = $this->numberToTuple($using);
        return static::tupleToJson($tuple);
    }

    private function stringToBoolean(string $using): bool
    {
        $array = $this->stringToArray($using);
        return $this->listToBoolean($array);
    }

    private function stringToInteger(string $using): int
    {
        $array = $this->stringToArray($using);
        return $this->listToInteger($array);
    }

    static public function stringToArray(
        string $using,
        string $divisor = "",
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): array
    {
        if (empty($divisor)) {
            return preg_split('//u', $using, -1, PREG_SPLIT_NO_EMPTY);

        } elseif (strlen($divisor) > 0) {
            $array = explode($divisor, $using, $limit);
            return ($includeEmpties) ? $array : array_filter($array);

        } else {
            return [];

        }
    }

    private function stringToDictionary(
        string $using,
        string $divisor = "",
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX,
        string $prefix = "i"
    )
    {
        $array = $this->stringToArray($using, $divisor, $includeEmpties, $limit);
        return $this->listToDictionary($array, $prefix);
    }

    private function stringToTuple(
        string $using,
        string $divisor = "",
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX,
        string $prefix = "i"
    )
    {
        return (object) $this->stringToDictionary($using,
            $divisor,
            $includeEmpties,
            $limit,
            $prefix
        );
    }

    private function stringToJson(
        string $using,
        string $divisor = "",
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX,
        string $prefix = "i"
    ): string
    {
        $tuple = $this->stringToTuple($using,
            $divisor,
            $includeEmpties,
            $limit,
            $prefix
        );
        return $this->tupleToJson($tuple);
    }

    private function listToBoolean(array $using): bool
    {
        return (bool) $this->listToInteger($using);
    }

    static public function listToInteger(array $using): int
    {
        return count($using);
    }

    private function listToFloat(array $using): float
    {
        return (float) $this->listToInteger($using);
    }

    static public function listToString(array $using, string $glue = ""): string
    {
        $using = array_filter($using, "is_string");
        return implode($glue, $using);
    }

    private function listToArray(array $using): array
    {
        return array_values($using);
    }

    static public function listToDictionary(array $using, string $prefix = "i"): array
    {
        if (TypeIs::applyWith("array")->unfoldUsing($using)) {
            $dictionary = [];
            foreach ($using as $key => $value) {
                if (is_int($key)) {
                    $key = $prefix . $key;
                }
                $dictionary[$key] = $value;
            }
            return $dictionary;
        }
        return array_filter($using, "is_string", ARRAY_FILTER_USE_KEY);
    }

    static public function listToTuple(array $using, string $prefix = "i"): object
    {
        return (object) static::listToDictionary($using, $prefix);
    }

    static public function listToJson(array $using, string $prefix = "i"): object
    {
        $tuple = static::listToTuple($using, $prefix);
        return static::tupleToJson($tuple);
    }

    private function tupleToBoolean(object $using): bool
    {
        $integer = $this->tupleToInteger($using);
        return $this->numberToBoolean($integer);
    }

    private function tupleToInteger(object $tuple): int
    {
        if (! TypeIs::applyWith("tuple")->unfoldUsing($tuple)) {
            return [];
        }
        $dictionary = $this->tupleToDictionary($tuple);
        return $this->listToInteger($dictionary);
    }

    private function tupleToFloat(object $tuple): float
    {
        if (! TypeIs::applyWith("tuple")->unfoldUsing($tuple)) {
            return [];
        }
        $dictionary = $this->tupleToDictionary($tuple);
        return $this->listToFloat($dictionary);
    }

    static public function tupleToArray(object $tuple): array
    {
        if (! TypeIs::applyWith("tuple")->unfoldUsing($tuple)) {
            return [];
        }
        $dictionary = static::tupleToDictionary($tuple);
        return static::listToArray($dictionary);
    }

    static public function tupleToDictionary(object $tuple): array
    {
        if (! TypeIs::applyWith("tuple")->unfoldUsing($tuple)) {
            return [];
        }
        return (array) $tuple;
    }

    private function tupleToJson(object $tuple): string
    {
        return json_encode($tuple);
    }

    private function objectToBoolean(object $object): bool
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return false;

        }

        if (is_a($object, Falsifiable::class)) {
            return $object->efToBool();

        }
        $integer = $this->objectToInteger($object);
        return $this->numberToBoolean($integer);
    }

    private function objectToInteger(object $object): int
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return 0;
        }
        $dictionary = $this->objectToDictionary($object);
        return $this->listToInteger($dictionary);
    }

    private function objectToFloat(object $object): float
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return 0.0;
        }
        $dictionary = $this->objectToDictionary($object);
        return $this->listToFloat($dictionary);
    }

    private function objectToArray(object $object): array
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return [];
        }
        $dictionary = $this->objectToDictionary($object);
        return $this->listToArray($dictionary);
    }

    private function objectToDictionary(object $object): array
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return [];
        }
        $tuple = $this->objectToTuple($object);
        return $this->tupleToDictionary($tuple);
    }

    private function objectToTuple(object $object): object
    {
        if (! TypeIs::applyWith("object")->unfoldUsing($object)) {
            return new stdClass;
        }

        $properties = get_object_vars($object);

        $filtered = array_filter($properties,
            function($v, $k) {
                return $v !== null and ! is_a($v, Closure::class);
            },
            ARRAY_FILTER_USE_BOTH
        );
        $tuple = (object) $filtered;
        return $tuple;
    }
}
