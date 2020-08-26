<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class HasMembers extends Filter
{
    private $membersSearch = [];
    private $useArray = true;

    // TODO: PHP 8.0 - int|string
    public function __construct($membersSearch, bool $useArray = true)
    {
        if (! TypeIs::applyWith("list")->unfoldUsing($membersSearch)) {
            if (TypeIs::applyWith("string")->unfoldUsing($membersSearch)) {
                $useArray = false;
            }
            $membersSearch = [$membersSearch];
        }

        $this->membersSearch = ($useArray)
            ? MinusUsing::applyWith("is_int")->unfoldUsing($membersSearch)
            : MinusUsing::applyWith("is_string")->unfoldUsing($membersSearch);

        $this->useArray = $useArray;
    }

    public function __invoke($using)
    {
        if (! TypeIs::applyWith("list")->unfoldUsing($using)) {
            if ($this->useArray) {
                return Shoop::pipe($using,
                    TypeAsArray::apply(),
                    HasMembers::applyWith($this->membersSearch, $this->useArray)
                )->unfold();

            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                HasMembers::applyWith($this->membersSearch, $this->useArray)
            )->unfold();

        }

        $members   = Members::applyWith($this->useArray)->unfoldUsing($using);
        $intersect = array_intersect($this->membersSearch, $members);

        if (TypeAsInteger::apply()->unfoldUsing($intersect) === 0) {
            return false;
        }

        return Shoop::pipe($this->membersSearch,
            TypeAsInteger::apply(),
            Is::applyWith(
                TypeAsInteger::apply()->unfoldUsing($intersect)
            )
        )->unfold();
    }
}
