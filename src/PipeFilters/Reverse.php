<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsJson;

class Reverse extends Filter
{
    private $preserveMembers = true;

    public function __construct(bool $preserveMembers = true)
    {
        $this->preserveMembers = $preserveMembers;
    }

    public function __invoke($using)
    {
        if (is_bool($using)) {
            return ! $using;

        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {
            return array_reverse($using, $this->preserveMembers);

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return Shoop::pipe($using,
                AsArray::apply(),
                Reverse::apply(),
                AsString::apply()
            )->unfold();

        }
        return [];
    }
}
