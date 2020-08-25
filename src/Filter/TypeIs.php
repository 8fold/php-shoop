<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

class TypeIs extends Filter
{
    private $type   = "boolean";

    // TODO: PHP 8.0 - Empty constructor
    public function __construct(string $type = "boolean", bool $strict = false)
    {
        $this->type   = $type;
        $this->strict = $strict;
    }

    public function __invoke($using): bool
    {
        $types = TypesOf::applyWith($this->strict)->unfoldUsing($using);
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
