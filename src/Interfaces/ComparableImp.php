<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESTypeMap,
    ESBool
};

use Eightfold\Shoop\Interfaces\Equatable;

trait ComparableImp
{
    public function isGreaterThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(true, $compare, $orEqualTo);
    }

    public function isLessThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(false, $compare, $orEqualTo);
    }

    private function compare(bool $greaterThan, $compare, $orEqualTo = false): ESBool
    {
        // TODO: Consider moving to trait
        $type = ESTypeMap::fromClassName(__CLASS__)->phpTypeName()->unwrap();
        $compare = $this->sanitizeTypeOrTriggerError($compare, $type)->unwrap();
        $orEqualTo = $this->sanitizeTypeOrTriggerError(
            $orEqualTo,
            "boolean",
            ESBool::class
        )->unwrap();
        if ($greaterThan) {
            return ($orEqualTo)
                ? ESBool::wrap($this->unwrap() >= $compare)
                : ESBool::wrap($this->unwrap() > $compare);
        }
        return ($orEqualTo)
            ? ESBool::wrap($this->unwrap() <= $compare)
            : ESBool::wrap($this->unwrap() < $compare);
    }
}
