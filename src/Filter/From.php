<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Contracts\Falsifiable;

// TODO: rename to "From(start, length, fromEnd)"
/**
 * Return a sequence of values less than or equal to `length` `From` a given `start` position integer.
 *
 * If `main` is a string, the result will be a string of the given length starting with character at the given `start` position. All other types are converted to their array representations.
 *
 * If `length` is 1, you will either receice the character at the given position or the value of the array for the given position.
 */
class From extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    // TODO: Consider adding argument of "fromEnd = false" or a method to avoid
    //      users needing to put in PHP_INT_MAX
    // TODO: PHP 8.0 - int|string
    public function __construct($start = 0, $length = PHP_INT_MAX)
    {
        if (is_a($start, Foldable::class)) {
            $start = $start->unfold();
        }
        $this->start = $start;

        if (is_a($length, Foldable::class)) {
            $length = $length->unfold();
        }
        $this->length = $length;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("string")->unfoldUsing($using)) {
            return substr($using, $this->start, $this->length);

        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
            $result = array_slice($using, $this->start, $this->length);

            return ($this->length === 1 or count($result) === 1)
                ? array_shift($result)
                : array_values($result);

        } else {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                From::applyWith($this->start, $this->length)
            )->unfold();

        }
    }
}
