<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use \stdClass;

use Eightfold\Foldable\Bend;

use Eightfold\Shoop\Shoop;

class ToObjectFromArray extends Bend
{
    public function __invoke(array $payload): object
    {
        $isDict = Shoop::pipeline($payload, ArrayIsDictionary::bend())->unfold();
        if ($isDict) {
            return (object) $payload;
        }
        return Shoop::pipeline($payload,
            ToDictionaryFromArray::bend(),
            ToObjectFromArray::bend()
        )->unfold();
    }
}
