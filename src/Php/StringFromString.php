<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class StringFromString extends Filter
{
    private $start = 0;
    private $length = 0;

    static public function bendWith(...$args)
    {
        return new static(...$args);
    }

    public function __construct(int $start = 0, int $length = 0)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke(string $using): string
    {
        if ($this->length === 0) {
            return substr($using, $this->start);
        }
        return substr($using, $this->start, $this->length);
    }
}
