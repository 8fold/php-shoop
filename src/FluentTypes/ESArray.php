<?php

namespace Eightfold\Shoop\FluentTypes;

use \Closure;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Addable;
use Eightfold\Shoop\FluentTypes\Contracts\AddableImp;

class ESArray implements Shooped, Addable
{
    use ShoopedImp, AddableImp;

    /**
     * @deprecated
     */
    public function reindex(): ESArray
    {
        $array = $this->main();
        $reindexed = array_values($array);
        return Shoop::this($reindexed);
    }

    /**
     * @deprecated
     */
    public function sum(): ESInteger
    {
        $array = $this->unfold();
        $sum = array_sum($array);
        return Shoop::this($sum);
    }

    // TODO: bool|ESBoolean
    /**
     * @deprecated
     */
    public function filter(Closure $closure, $useValues = true, $useMembers = false): ESArray
    {
        $useValues  = Type::sanitizeType($useValues, ESBoolean::class);
        $useMembers = Type::sanitizeType($useMembers, ESBoolean::class);

        $flag = 0;
        if ($useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_BOTH;

        } elseif (! $useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_KEY;

        }
        $filtered = array_filter($this->main(), $closure, $flag);
        $array = array_values($filtered);
        return Shoop::this($array);
    }

    /**
     * @deprecated
     */
    public function flatten(): ESArray
    {
        $array = $this->main();
        $a = Shoop::this([]);
        array_walk_recursive($array, function($value, $index) use (&$a) {
            $shooped = Shoop::this($value);
            $a = $a->plus($shooped);
        });
        return $a;
    }

    // TODO: PHP 8.0 string|ESString = $delimiter
    /**
     * @deprecated
     */
    public function join($delimiter = ""): ESString
    {
        return ESString::fold(
            $this->asString($delimiter)
        );
    }
}
