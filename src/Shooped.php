<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\Filter\TypesOf;
use Eightfold\Shoop\Filter\TypeIs;

use Eightfold\Shoop\FilterContracts\Shooped as ShoopedInterface;

use Eightfold\Shoop\FilterContracts\Interfaces\Addable;
use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;
use Eightfold\Shoop\FilterContracts\Interfaces\Comparable;
use Eightfold\Shoop\FilterContracts\Interfaces\Countable;
use Eightfold\Shoop\FilterContracts\Interfaces\Emptiable;
use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;
use Eightfold\Shoop\FilterContracts\Interfaces\Reversible;
use Eightfold\Shoop\FilterContracts\Interfaces\Stringable;
use Eightfold\Shoop\FilterContracts\Interfaces\Subtractable;
use Eightfold\Shoop\FilterContracts\Interfaces\Tupleable;

class Shooped implements ShoopedInterface
{
    use FoldableImp;

    public function __construct($main)
    {
        $this->main = $main;
    }

// - Maths
    // TODO: PHP 8 - mixed, string|int
    public function plus($value, $at = ""): Addable
    {
        if (! $this->typeCheckForArgument($at, ["string", "integer"])) {
            $this->typeCheckForArgument(
                $at,
                ["string", "integer"],
                true,
                static::class ."::". __FUNCTION__ ."()",
                2
            );
        }

        return static::fold(
            Apply::plus($value)->unfoldUsing($this->main)
        );
    }

    // TODO: PHP 8 - array|int
    public function minus(
        $items = [" ", "\t", "\n", "\r", "\0", "\x0B"],
        bool $fromStart = true,
        bool $fromEnd   = true
    ): Subtractable
    {
        if (! $this->typeCheckForArgument($items, ["string", "integer", "array"])) {
            $this->typeCheckForArgument(
                $items,
                ["string", "integer", "array"],
                true,
                static::class ."::". __FUNCTION__ ."()",
                1
            );
        }

        return static::fold(
            Apply::minus($items, $fromStart, $fromEnd)->unfoldUsing($this->main)
        );
    }

// - Arrayable
    public function asArray(
        $start = 0, // int|string
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): Arrayable
    {
        return static::fold(
            Apply::typeAsArray($start, $includeEmpties, $limit)
                ->unfoldUsing($this->main)
        );
    }

    public function efToArray(): array
    {
        return $this->asArray()->unfold();
    }

// - Associable
    public function asDictionary(): Associable
    {
        return static::fold(
            Apply::typeAsDictionary()->unfoldUsing($this->main)
        );
    }

    public function efToDictionary(): array
    {
        return $this->asDictionary()->unfold();
    }

    public function has($value): Falsifiable
    {
        // TODO: Consider switching priority - call efHas and wrap result, is
        //      there a performance difference?? Are people using fluent more
        //      likely to continue chaining or wanting to bail??
        return static::fold(
            Apply::has($value)->unfoldUsing($this->main)
        );
    }

    public function efHas($value): bool
    {
        return $this->has($value)->unfold();
    }

    public function hasAt($member): Falsifiable
    {
        return static::fold(
            Apply::hasAt($member)->unfoldUsing($this->main)
        );
    }

    public function offsetExists($offset): bool // ArrayAccess
    {
        return $this->hasAt($offset)->unfold();
    }

    public function at($member)
    {
        return static::fold(
            Apply::at($member)->unfoldUsing($this->main)
        );
    }

    public function offsetGet($offset) // ArrayAccess
    {
        return $this->at($offset)->unfold();
    }

    public function plusAt(
        $value, // mixed
        $member = PHP_INT_MAX, // int|string
        bool $overwrite = false
    ): Associable
    {
        $this->main = Apply::plusAt($value, $member, $overwrite)
            ->unfoldUsing($this->main);
        return $this;
    }

    public function offsetSet($offset, $value): void // ArrayAccess
    {
        $this->plusAt($value, $offset);
    }

    public function minusAt($member): Associable
    {
        $this->main = Apply::minusAt($member)->unfoldUsing($this->main);
        return $this;
    }

    public function offsetUnset($offset): void // ArrayAcces
    {
        $this->main = $this->minusAt($member);
    }

    private $temp;

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     */
    public function rewind(): void // Iterator
    {
        $this->temp = (TypeIs::applyWith("sequential")->unfoldUsing($this->main))
            ? Apply::typeAsArray()->unfoldUsing($this->main)
            : Apply::typeAsDictionary()->unfoldUsing($this->main);
    }

    public function valid(): bool // Iterator
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $member = key($this->temp);
        return array_key_exists($member, $this->temp);
    }

    public function current() // Iterator
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $member = key($temp);
        return $temp[$member];
    }

    public function key() // Iterator
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        return key($this->temp);
    }

    public function next(): void // Iterator
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }

// - Emptiable TODO: create interface
    public function isEmpty(): Falsifiable
    {
        return static::fold(
            Apply::isEmpty()->unfoldUsing($this->main)
        );
    }

    public function efIsEmpty(): bool
    {
        return $this->isEmpty()->unfold();
    }

// - Falsifiable
    public function asBoolean(): Falsifiable
    {
        return static::fold(
            Apply::typeAsBoolean()->unfoldUsing($this->main)
        );
    }

    public function efToBoolean(): bool
    {
        return $this->asBoolean()->unfold();
    }

// - Stringable
    public function asString(string $glue = ""): Stringable
    {}

    public function efToString(string $glue = ""): string
    {}

    public function __toString(): string
    {}

// - Tupleable
    public function asTuple(): Tupleable
    {}

    // PHP 8.0 - stdClass|object
    public function efToTuple(): object
    {}

    public function asJson(): Tupleable
    {}

    public function efToJson(): string
    {}

    public function jsonSerialize(): object // JsonSerializable
    {}

// - Comparable
    public function is($compare): Falsifiable
    {
    }

    public function isGreaterThan($compare): Falsifiable
    {}

    public function isGreaterThanOrEqualTo($compare): Falsifiable
    {}

// - Countable
    public function asInteger(): Countable
    {}

    public function efToInteger(): int
    {}

    public function count(): int // Countable
    {}

// - Reversible
    public function reverse(): Reversible
    {}

// - Typeable
    public function types(): Arrayable
    {}

    public function efTypes(): array
    {}

// - Utilities
    private function typeCheckForArgument(
        $given,
        array $validTypes,
        bool $triggerError = false,
        string $function   = "",
        int $argNumber     = 1
    ): bool
    {
        $givenTypes = TypesOf::apply()->unfoldUsing($given);
        $matchesAny = ! empty(array_intersect($validTypes, $givenTypes));
        if ($matchesAny) {
            return true;

        } elseif (! $matchesAny and ! $triggerError) {
            return false;

        }

        $typeMessage = function(array $types, string $conjunction = "or") {
            $message = implode(", ", $types);
            if (count($types) === 2) {
                $message = implode(" {$conjunction} ", $types);

            } elseif ($count = count($types) > 2) {
                $types[$count - 1] = "{$conjunction} ". $types[$count - 1];

                $message = implode(", ", $types);

            }
            return $message;
        };

        $givenMessage = $typeMessage($givenTypes, "and");
        $validMessage = $typeMessage($validTypes);
        $message = "Shoop Fatal error:  Uncaught TypeError: Argument {$argNumber} passed to {$function} must be of {$validMessage} type(s); {$givenMessage} given.";
        trigger_error($message);
    }
}
