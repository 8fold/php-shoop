<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

// TODO: get($key) - ESArray, ESDictionary
class ESDictionary implements
    \Iterator,
    Shooped
{
    use ShoopedImp;

    public function __construct($dictionary)
    {
        if (is_array($dictionary) && Type::isDictionary($dictionary)) {
            $this->value = $dictionary;

        } elseif (is_a($dictionary, ESDictionary::class)) {
            $this->value = $dictionary->unfold();

        } else {
            $this->value = [];

        }
    }

// - Type Juggling
    // TODO: Alias called values
    public function array(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    public function dictionary(): ESDictionary
    {
        return Shoop::dictionary($this->unfold());
    }

   /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

// - PHP single-method interfaces
    public function __toString()
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        return $commas;
    }

// - Manipulate
    public function toggle($preserveMembers = true): ESDictionary
    {
        // TODO: Array flip
        $preserveMembers = Type::sanitizeType($preserveMembers, ESBool::class)->unfold();
        $array = array_reverse($this->unfold(), $preserveMembers);
        return static::fold($array);
    }

    public function sort($caseSensitive = true): ESDictionary
    {
        $caseSensitive = Type::sanitizeType($caseSensitive, ESBool::class)->unfold();
        $array = $this->value;
        if ($caseSensitive) {
            natsort($array);

        } else {
            natcasesort($array);

        }
        return Shoop::dictionary($array);
    }

    public function shuffle(): ESDictionary
    {
        $array = $this->unfold();
        shuffle($array);
        return Shoop::dictionary($array);
    }

    public function start(...$prefixes)
    {
        return $this->plus(...$prefixes);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            if ($this->has($val)->toggleUnfolded()) {
                return Shoop::bool(false);
            }
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        return $this->startsWith($needle);
    }

// - Math language
    public function plus(...$args)
    {
        if (Shoop::array($args)->count()->isNotUnfolded(2)) {
            $className = ESDictionary::class;
            $count = Shoop::array($args)->count();
            trigger_error(
                "{$className}::plus() expects two arguments. {$count} given."
            );
        }

        $key = Type::sanitizeType($args[0], ESString::class)->unfold();

        $dict = $this->unfold();
        $dict[$key] = $args[1];
        return Shoop::dictionary($dict);
    }

    public function minus(...$args): ESDictionary
    {
        $stash = $this->value;
        foreach ($args as $delete) {
            $member = Type::sanitizeType($delete, ESString::class)->unfold();
            unset($stash[$member]);
        }
        return Shoop::dictionary($stash);
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

    public function divide($value = null)
    {
        $keys = $this->members();
        $values = $this->array();
        return Shoop::dictionary(["keys" => $keys, "values" => $values]);
    }

// - Comparison
// - Other
    public function get($member)
    {
        $member = Type::sanitizeType($member, ESString::class)->unfold();
        if ($this->hasMember($member)) {
            return Shoop::this($this[$member]);
        }
        trigger_error("Undefined index or memember.");
    }

    // TODO: Promote to ShoopedImp, with custom for ESString
    public function hasMember($member): ESBool
    {
        $member = Type::sanitizeType($member, ESString::class)->unfold();
        return Shoop::bool($this->offsetExists($member));
    }

    public function doesNotHaveMember($member): ESBool
    {
        return $this->hasMember($member)->toggle();
    }

    private function members(): ESArray
    {
        return Shoop::array(array_keys($this->value));
    }

    public function values(): ESArray
    {
        return $this->array();
    }
}
