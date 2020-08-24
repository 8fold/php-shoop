<?php

namespace Eightfold\Shoop\FluentTypes;

use \Closure;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

// use Eightfold\Shoop\PipeFilters\TypeAsString;

class ESArray implements Shooped
{
    use ShoopedImp;

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

    public function sum(): ESInteger
    {
        $array = $this->unfold();
        $sum = array_sum($array);
        return Shoop::this($sum);
    }

    // TODO: PHP 8.0 int|ESInteger
    public function random($limit = 1): ESArray
    {
        $limit = Type::sanitizeType($limit, ESInteger::fold($limit))->unfold();
        $array = $this->main();
        if (count($array) === 0) {
            return Shoop::this([]);
        }

        $members = array_rand($array, $limit);
        if ($limit === 1) {
            $members = [$members];
        }

        $build = [];
        foreach ($members as $member) {
            $build[] = $array[$member];
        }

        return Shoop::this($build);
    }

    // TODO: bool|ESBoolean
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

    public function reindex(): ESArray
    {
        $array = $this->main();
        $reindexed = array_values($array);
        return Shoop::this($reindexed);
    }

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
}
