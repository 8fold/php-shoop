<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

class FromList extends Filter
{
    private $member = "";
    private $useArray = false;

    // TODO: PHP 8.0 - int|float|string|array
    public function __construct($members = "")
    {
        if (IsListOfStrings::apply()->unfoldUsing($members)) {
            die("From list, use dictionary");

        } elseif (IsListOfIntegers::apply()->unfoldUsing($members)) {
            $this->useArray = true;
            die("From list, use array");

        } elseif (IsString::apply()->unfoldUsing($members)) {
            die("From string, use dictionary");

        } elseif (IsNumber::apply()->unfoldUsing($members)) {
            $this->useArray = true;
            die("From number, use array");

        }
    }

    // TODO: PHP 8.0 - not null -> int|float|string|array|object
    public function __invoke(array $using)
    {
        if (isset($using[$this->member])) {
            return $using[$this->member];
        }
        return [];
    }
}
