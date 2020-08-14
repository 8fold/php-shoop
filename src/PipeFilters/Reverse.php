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

    public function __invoke($payload)
    {
        if (is_bool($payload)) {
            return ! $payload;

        } elseif (is_int($payload)) {
            // return Shoop::pipe($payload, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($payload)) {
            // ToArrayFromObject

        } elseif (is_array($payload)) {
            return array_reverse($payload, $this->preserveMembers);

        } elseif (is_string($payload)) {
            $isJson = Shoop::pipe($payload, StringIsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($payload, ToArrayFromJson::apply())
                //     ->unfold();
            }
            return Shoop::pipe($payload,
                AsArray::apply(),
                Reverse::apply(),
                AsString::apply()
            )->unfold();

        }
        return [];
    }
}
