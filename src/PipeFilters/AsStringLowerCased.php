<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Php\StringIsJson;

class AsStringLowerCased extends Filter
{
    private $length = 1;

    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    public function __invoke($using)
    {
        if (is_bool($using)) {
            // ToArrayFromBoolean
        } elseif (is_int($using)) {
            // return Shoop::pipe($using, ToArrayFromInteger::apply())->unfold();

        } elseif (is_object($using)) {
            // ToArrayFromObject

        } elseif (is_array($using)) {

        } elseif (is_string($using)) {
            $isJson = Shoop::pipe($using, IsJson::apply())->unfold();
            if ($isJson) {
                // return Shoop::pipe($using, ToArrayFromJson::apply())
                //     ->unfold();
            }
            if ($length === 1) {
                return lcfirst($using);

            }
            return mb_strtolower($using);
        }
        return [];
    }
}
