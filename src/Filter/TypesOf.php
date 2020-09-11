<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\FilterContracts\Interfaces\Typeable;
use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;

// TODO: rename TypesFor - add sequential
class TypesOf extends Filter
{
    public function __invoke($using): array
    {
        // var_dump($using);
        if (is_bool($using)) { // Done
            return ["boolean"];

        } elseif (! is_string($using) and is_numeric($using)) {
            if (is_integer($using) or floor($using) === $using) { // done
                return (is_float($using))
                    ? ["sequential", "number", "integer", "float"]
                    : ["sequential", "number", "integer"];

            } elseif (is_float($using)) {
                return ["sequential", "number", "float"];

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
                ? ["collection", "tuple", "json"] // done
                : ["sequential", "string"]; // done

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
                return ["collection", "list", "dictionary"]; // DONE

            } elseif (count($intMembers) > 0 and
                count($intMembers) === count($using)
            ) {
                // all keys are integers
                $count = count($intMembers);
                $start = $members[0];
                $end   = $members[$count - 1];
                $range = range($start, $end);

                if ($members === $range) {
                    return ["sequential", "collection", "list", "array"]; // DONE

                }

            }
            return ["collection", "list"];

        } elseif (is_object($using) and
            (is_a($using, stdClass::class) or empty(get_class_methods($using)))
        ) {
            return ["collection", "tuple"]; // done

        } elseif (is_object($using)) {
            $types = ["object"];

            // TODO: Check for various contracts
            if (is_a($using, Arrayable::class)) {
                $types[] = "arrayable";
            }
            return $types;
        }
        // die("falling through typeof");
        // TODO: Consider type error warrning
    }
}
