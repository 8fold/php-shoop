<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESBool
};

trait SortImp
{
    public function sort($caseSensitive = true)
    {
        $caseSensitive = Type::sanitizeType($caseSensitive, ESBool::class)->unfold();
        $array = $this->array()->unfold();
        if ($caseSensitive) {
            natsort($array);

        } else {
            natcasesort($array);

        }
        return Shoop::array(array_values($array));
    }
}
