<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;

use Eightfold\Shoop\PipeFilters\At\FromNumber;
use Eightfold\Shoop\PipeFilters\At\FromList;
use Eightfold\Shoop\PipeFilters\At\FromString;
use Eightfold\Shoop\PipeFilters\At\FromTuple;
use Eightfold\Shoop\PipeFilters\At\FromJson;

use Eightfold\Shoop\PipeFilters\TypeIs;
use Eightfold\Shoop\PipeFilters\TypeAs;

class At extends Filter
{
    private $members = [];

    public function __construct(...$members)
    {
        $this->members = $members;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            // TODO

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return $this->atFromNumber($using, ...$this->members);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
                $using = TypeAs::stringToArray($using);
                if (TypeAs::listToInteger($this->members) === 1) {
                    return $this->atFromArraySingle($using, $this->members[0]);

                } else {
                    $array = $this->atFromArrayMultiple($using, ...$this->members);
                    return TypeAs::listToString($array);

                }
                return false;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("array")->unfoldUsing($using)) {
                return (TypeAs::listToInteger($this->members) === 1)
                    ? $this->atFromArraySingle($using, $this->members[0])
                    : $this->atFromArrayMultiple($using, ...$this->members);

            } elseif (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                return (TypeAs::listToInteger($this->members) === 1)
                    ? $this->atFromDictionarySingle($using, $this->members[0])
                    : $this->atFromDictionaryMultiple($using, ...$this->members);

            }
            return false;

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (TypeIs::integerList($this->members)) {
                $using = TypeAs::tupleToArray($using);
                $using = (TypeAs::listToInteger($this->members) === 1)
                    ? $this->atFromArraySingle($using, $this->members[0])
                    : $this->atFromArrayMultiple($using, ...$this->members);
                $using = TypeAs::listToDictionary($using);
                return TypeAs::listToTuple($using);

            }
            $using = TypeAs::tupleToDictionary($using);
            return (object) (TypeAs::listToInteger($this->members) === 1)
                ? $this->atFromDictionarySingle($using, $this->members[0])
                : $this->atFromDictionaryMultiple($using, ...$this->members);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            // TODO

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            // TODO: tests + implementation
            // $windUp = Shoop::pipe($using,
            //     AsTupleFromJson::apply(),
            //     AsDictionaryFromTuple::apply(),
            //     AtFromDictionary::applyWith(...$this->members),
            // )->unfold();

            // if (count($this->members) === 1) {
            //     return $windUp;
            // }
            // return Shoop::pipe($windUp,
            //     AsTupleFromDictionary::apply(),
            //     AsJsonFromTuple::apply()
            // )->unfold();

        }
    }

    // TODO: PHP 8.0 - int|float, string|int|float
    static private function atFromNumber($using, ...$members)
    {
        $integer = TypeAs::numberToInteger($using);
        $array   = TypeAs::numberToArray($integer);
        if (TypeAs::listToInteger($members) === 1) {
            return static::atFromArraySingle($array, $members[0]);
        }
        return static::atFromArrayMultiple($array, ...$members);
    }

    // TODO: PHP 8.0 - string|int|float
    static public function atFromArraySingle(array $using, int $member)
    {
        return static::atFromList($using, $member);
    }

    static public function atFromArrayMultiple(array $using, int ...$members)
    {
        return array_values(static::atFromList($using, ...$members));
    }

    static public function atFromDictionarySingle(array $using, string $member)
    {
        return static::atFromList($using, $member);
    }

    static public function atFromDictionaryMultiple(array $using, string ...$members)
    {
        return static::atFromList($using, ...$members);
    }

    static private function atFromList(array $using, ...$members)
    {
        if (TypeAs::listToInteger($members) === 1) {
            $member = $members[0];
            return (isset($using[$member])) ? $using[$member] : false;
        }
        $build = [];
        foreach ($members as $member) {
            if (isset($using[$member])) {
                $build[$member] = $using[$member];

            }
        }
        return $build;
    }
}
