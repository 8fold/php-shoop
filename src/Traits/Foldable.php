<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait Foldable
{
    protected $value;

    static public function fold($args): self
    {
        return new static($args);
    }

    public function unfold()
    {
        return $this->value;
    }

//-> Getters
    public function __call(string $name, array $args = [])
    {
        $call = $this->callFromName($name);
        $result = $this->{$call}(...$args);
        if (Shoop::valueIsShooped($result)) {
            return $result->unfold();

        }
        return $result;
    }

    private function callFromName(string $name)
    {
        $call = "";
        $start = strlen($name) - strlen("Unfolded");
        $isFolded = $this->methodNameContains("Unfolded", $name, $start);
        if ($isFolded) {
            $call = lcfirst(substr_replace($name, "", $start, strlen($name) - $start));
        }

        if (strlen($call) === 0) {
            $className = static::class;
            trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);
        }
        return $call;
    }

    private function methodNameContains(string $needle, string $haystack, int $start)
    {
        $needle = $needle;
        $end = strlen($haystack);
        $len = strlen($needle);
        return substr($haystack, $start, $len) === $needle;
    }
}
