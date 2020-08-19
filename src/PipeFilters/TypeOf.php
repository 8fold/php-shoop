<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

class TypeOf extends Filter
{
    private $strict = false;

    public function __construct(bool $strict = false)
    {
        $this->strict = $strict;
    }

    public function __invoke($using): array
    {
        $types = [];
        if (is_bool($using)) {
            $types[] = "boolean";

        } elseif (! is_string($using) and is_numeric($using)) {
            if (! $this->strict) {
                $types[] = "number";
            }

            $string      = strval($using);
            $pointCheck  = explode(".", $string, 2);

            if (($this->strict and is_integer($using)) or
                (! $this->strict and count($pointCheck) === 1)
            ) {
                $types[] = "integer";

            }

            if (is_float($using)) {
                $types[] = "float";

            }

        } elseif (is_string($using)) {
            if ($this->strict) {
                $types[] = "string";

            } elseif (! $this->strict) {
                $length = strlen($using);
                $mightBeJson = true;
                if ($length < 2) {
                    $mightBeJson = false;

                } elseif ($using[0] !== "{") {
                    $mightBeJson = false;

                } elseif ($using[$length - 1] !== "}") {
                    $mightBeJson = false;

                } elseif (! is_object(json_decode($using))) {
                    $mightBeJson = false;

                }

                if ($mightBeJson and json_last_error() === JSON_ERROR_NONE) {
                    $types[] = "collection";
                    $types[] = "tuple";
                    $types[] = "json";

                } else {
                    $types[] = "string";

                }
            }

        } elseif (is_array($using) or is_object($using)) {
            if ((is_object($using) and is_a($using, stdClass::class)) or
                (is_object($using) and empty(get_class_methods($using)))
            ) {
                $types[] = "collection";
                $types[] = "tuple";

            } elseif (is_object($using)) {
                $types[] = "object";

            } elseif (is_array($using)) {
                $types[] = "collection";
                $types[] = "list";
                if (count($using) > 0) {
                    $members       = array_keys($using);
                    $intMembers    = array_filter($members, "is_int");
                    $stringMembers = array_filter($members, "is_string");
                    if (count($intMembers) > 0 and
                        count($intMembers) === count($using)
                    ) {
                        // all keys are integers
                        $count = count($intMembers);
                        $start = $members[0];
                        $end   = $members[$count - 1];
                        $range = range($start, $end);
                        if ($members === $range) {
                            // members are sequential
                            $types[] = "array";

                        }

                    } elseif (count($stringMembers) > 0 and
                        count($stringMembers) === count($using)
                    ) {
                        // all keys are strings
                        $types[] = "dictionary";

                    }
                }
            }
        }
        return $types;
    }
}
