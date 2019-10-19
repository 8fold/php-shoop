<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Countable,
    Toggle,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    ToggleImp,
    HasImp
};

use Eightfold\Shoop\ESInt;

// TODO: get($key) - ESArray, ESDictionary
class ESDictionary implements
    \Iterator,
    Shooped,
    Countable,
    Toggle,
    Has
{
    use ShoopedImp, CountableImp, ToggleImp, HasImp;

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
    public function string(): ESString
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        return Shoop::string($commas);
    }

    public function array(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    public function dictionary(): ESDictionary
    {
        return Shoop::dictionary($this->unfold());
    }

    public function json(): ESJson
    {
        return Shoop::json(json_encode($this->unfold()));
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true): ESDictionary
    {
        $array = array_flip($this->unfold());
        return static::fold($array);
    }

// - Search
// - Math language
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

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

    private function members(): ESArray
    {
        return Shoop::array(array_keys($this->value));
    }
}
