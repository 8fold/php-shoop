<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

/**
 * Return whether a content or collection type `Has` one or more values `At` the specified location(s).
 *
 * If the `membersSearch` is a list of integers, an array representation is used.
 *
 * If the `membersSearch` is a list of strings, a dictionary representation is used.
 *
 * If the `membersSearch` is a mixed array, an array of strings is used, which means `At` maybe become empty; thereby returning false.
 *
 * If the `membersSearch` is a single value that value is placed in an array and used.
 *
 *
 */
class HasAt extends Filter
{
    private $membersSearch = [];

    // TODO: PHP 8.0 - int|string
    public function __construct($membersSearch)
    {
        $this->membersSearch = $membersSearch;
    }

    public function __invoke($using)
    {
        if (! TypeIs::applyWith("list")->unfoldUsing($this->membersSearch)) {
            $this->membersSearch = [$this->membersSearch];

        }

        if (! TypeIsArrayOfStrings::apply()->unfoldUsing($this->membersSearch) and
            ! TypeIsArrayOfIntegers::apply()->unfoldUsing($this->membersSearch)
        ) {
            $this->membersSearch = Apply::retainUsing("is_string")
                ->unfoldUsing($this->membersSearch);
        }

        $useDictionary = true;
        if (TypeIsArrayOfIntegers::apply()->unfoldUsing($this->membersSearch)) {
            $useDictionary = false;
        }


        // TODO: Filter - TypeIsArrayOfStrings, TypeIsArrayOfIntegers
        if (! TypeIs::applyWith("list")->unfoldUsing($using)) {
            if ($useDictionary) {
                return Shoop::pipe($using,
                    TypeAsDictionary::apply(),
                    HasAt::applyWith($this->membersSearch)
                )->unfold();
            }

            return Shoop::pipe($using,
                TypeAsArray::apply(),
                HasAt::applyWith($this->membersSearch)
            )->unfold();

        }

        return Shoop::pipe($using,
            ($useDictionary) ? Apply::typeAsDictionary() : Apply::typeAsArray(),
            Apply::members(),
            Apply::shared($this->membersSearch), // TODO: unique
            Apply::typeAsInteger(),
            Apply::is(0),
            Apply::reversed()
        )->unfold();
    }
}
