<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\DropEmpties;

class FromString extends Filter
{
    private $divisor = "";
    private $withEmpties = true;
    private $limit = PHP_INT_MAX;

    public function __construct(
        string $divisor   = "",
        bool $withEmpties = true,
        int $limit        = PHP_INT_MAX
    )
    {
        $this->divisor     = $divisor;
        $this->withEmpties = $withEmpties;
        $this->limit       = $limit;
    }

    public function __invoke(string $using): array
    {
        if (strlen($this->divisor) === 0) {
            return preg_split('//u', $using, -1, PREG_SPLIT_NO_EMPTY);
        }
        $array = explode($this->divisor, $using, $this->limit);
        return ($this->withEmpties)
            ? $array
            : Shoop::pipe($array, DropEmpties::apply(), AsArray::apply())->unfold();
    }
}
