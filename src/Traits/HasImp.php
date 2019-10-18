<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\ESBool;

trait HasImp
{
    public function has($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        $bool = in_array($needle, $this->array()->unfold());
        return Shoop::bool($bool);
    }
}
