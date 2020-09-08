<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Contracts\Falsifiable;

// TODO: rename to "From(start, length, fromEnd)"
class From extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    // TODO: Consider adding argument of "fromEnd = false" or a method to avoid
    //      users needing to put in PHP_INT_MAX
    // TODO: PHP 8.0 - int|string
    public function __construct($start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            if (is_int($this->start)) {
                return Shoop::pipe($using,
                    TypeAsArray::apply(),
                    At::applyWith($this->start)
                )->unfold();

            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->start)
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return substr($using, $this->start, $this->length);

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $preserveKeys = true;
            if (TypeIs::applyWith("array")->unfoldUsing($using)) {
                $preserveKeys = false;

            }
            return array_slice($using, $this->start, $this->length, $preserveKeys);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                From::applyWith($this->start, $this->length),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            $dictionary = TypeAsDictionary::apply()->unfoldUsing($using);
            $dictionary = From::applyWith($this->start, $this->length)
                ->unfoldUsing($dictionary);

            return TypeAsJson::apply()->unfoldUsing($dictionary);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        }
    }
}
