<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;

trait Foldable
{
    protected $value;

    static public function fold($value): self
    {
        return new static($value);
    }

    public function unfold()
    {
        return $this->value;
    }

//-> Getters
    public function __call(string $name, array $args = [])
    {
        $call = $this->knownMethodFromUnknownName($name);
        $result = $this->{$call}(...$args);
        if (Type::isShooped($result)) {
            return $result->unfold();
        }
        return $result;
    }

    private function knownMethodFromUnknownName(string $name)
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
