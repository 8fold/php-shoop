<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeOf;

class TypeIs extends Filter
{
    private $type   = "boolean";
    private $strict = false;

    public function __construct(string $type = "boolean", bool $strict = false)
    {
        $this->type   = $type;
        $this->strict = $strict;
    }

    public function __invoke($using): bool
    {
        if ($this->type === "integer_list") {


        } elseif ($this->type === "string_list") {

        }
        $types = TypeOf::applyWith($this->strict)->unfoldUsing($using);
        return (in_array($this->type, $types)) ? true : false;
    }

    static public function integerList(array $using): bool
    {
        $integerList = array_filter($using, "is_int");
        return count($using) === count($integerList);
    }

    static public function stringList(array $using): bool
    {
        $stringList = array_filter($using, "is_string");
        return count($using) === count($stringList);
    }
}
