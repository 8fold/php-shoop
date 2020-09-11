<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\RetainUsing;

use Eightfold\Shoop\FilterContracts\Interfaces\Stringable;

class AsString extends Filter
{
    public function __invoke($using): string
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {


        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return strval($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) or
            TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $using;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                $using = TypeAsDictionary::apply()->unfoldUsing($using);
            }
            $strings = MinusUsing::applyWith("is_string")->unfoldUsing($using);
            // $strings = array_filter($using, "is_string"); // TODO: Move to Minus
            return implode($this->glue, $strings);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (TypeIs::applyWith("jsong")->unfoldUsing($using)) {
                return TypeAsJson::apply()->unfoldUsing($using);
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                TypeAsString::apply()
            )->unfold();
        }
    }

    static public function fromBoolean(bool $using): string
    {
        return ($using) ? "true" : "false";
    }

    // TODO: PHP 8 - int|float
    /**
     * Convert a given number to a string representation of that number.
     *
     * @param  int|integer|float|double $using             The number to process.
     * @param  int|integer              $decimalPlaces     Number of decimal places to force. Default is 1 to circumvent dynamic typing back to an integer or float when used as members of dictionaries and tuples.
     * @param  string                   $decimalPoint      The character to separate whole numbers and decimal values.
     * @param  string                   $thousandSeparator The character to separate counts of one-thousand.
     * @return string                                      A string in the specified format.
     */
    static public function fromNumber(
        $using,
        int $decimalPlaces        = 1,
        string $decimalPoint      = ".",
        string $thousandSeparator = ","
    ): string
    {
        return number_format(
            $using,
            $decimalPlaces,
            $decimalPoint,
            $thousandSeparator
        );
    }

    static public function fromString(string $using): string
    {
        return $using;
    }

    static public function fromList(array $using, string $glue = ""): string
    {
        $array = RetainUsing::fromList($using, "is_string");
        return implode($glue, $array);
    }

    static public function fromTuple($using): string
    {
        $dictionary = AsDictionary::fromTuple($using);
        return static::fromList($dictionary);
    }

    static public function fromJson(string $using): string
    {
        $tuple = AsDictionary::fromJson($using);
        return static::fromList($tuple);
    }

    static public function fromObject(object $using): string
    {
        return (is_a($using, Stringable::class))
            ? $using->efToString()
            : static::fromTuple($using);
    }
}
