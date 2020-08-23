<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;

// TODO: TypesFor
class TypeOf extends Filter
{
    public function __invoke($using): array
    {
        if (is_bool($using)) {
            return ["boolean"];

        } elseif (! is_string($using) and is_numeric($using)) {
            if (is_integer($using) or floor($using) === $using) {
                return (is_float($using))
                    ? ["number", "integer", "float"]
                    : ["number", "integer"];

            } elseif (is_float($using)) {
                return ["number", "float"];

            }

        } elseif (is_string($using)) {
            $mightBeJson = true;
            if (strlen($using) < 2) {
                $mightBeJson = false;

            } elseif ($using[0] !== "{") {
                $mightBeJson = false;

            } elseif ($using[strlen($using) - 1] !== "}") {
                $mightBeJson = false;

            } elseif (! is_object(json_decode($using))) {
                $mightBeJson = false;

            }

            return ($mightBeJson and json_last_error() === JSON_ERROR_NONE)
                ? ["collection", "tuple", "json"]
                : ["string"];

        } elseif (is_array($using)) {
            if (empty($using)) {
                return ["collection", "list"];
            }

            $members       = array_keys($using);
            $intMembers    = array_filter($members, "is_int");
            $stringMembers = array_filter($members, "is_string");

            if (count($stringMembers) > 0 and
                count($stringMembers) === count($using)
            ) {
                return ["collection", "list", "dictionary"];

            } elseif (count($intMembers) > 0 and
                count($intMembers) === count($using)
            ) {
                // all keys are integers
                $count = count($intMembers);
                $start = $members[0];
                $end   = $members[$count - 1];
                $range = range($start, $end);

                if ($members === $range) {
                    return ["collection", "list", "array"];

                }

            } else {
                return ["collection", "list"];

            }

        } elseif (is_object($using) and
            (is_a($using, stdClass::class) or empty(get_class_methods($using)))
        ) {
            return ["collection", "tuple"];

        } elseif (is_object($using)) {
            $types = ["object"];

            if (is_a($using, Arrayable::class)) {
                $types[] = "arrayable";

            }

            return $types;
        }
    }
}
