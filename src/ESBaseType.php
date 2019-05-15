<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

class ESBaseType
{
    protected $value;

    static public function wrap(...$args): ESBaseType
    {
        return new ESBaseType(...$args);
    }

    public function __construct(...$args)
    {
        $this->value = $args[0];
    }

    public function unwrap()
    {
        return $this->value;
    }

    public function isEmpty(): ESBool
    {
        $result = empty($this->unwrap());
        return ESBool::wrap($result);
    }

//-> Comparison
    final public function isSameAs(ESBaseType $compare): ESBool
    {
        $result = $this->unwrap() === $compare->unwrap();
        return ESBool::wrap($result);
    }

    final public function isDifferentThan(ESBaseType $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }

//-> Randomizer
    final public function randomWithMethod(\Closure $method)
    {
        return $method($this);
    }
}
