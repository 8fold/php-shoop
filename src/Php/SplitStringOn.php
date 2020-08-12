<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Shoop\Php;

class SplitStringOn
{
    private $splitter;
    private $includeEmpties = true;
    private $limit = PHP_INT_MAX;

    public function __construct(
        string $splitter,
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    )
    {
        $this->splitter = $splitter;
        $this->includeEmpties = $includeEmpties;
        $this->limit = $limit;
    }

    public function __invoke(string $payload): array
    {
        $array = explode($this->splitter, $payload, $this->limit);
        return ($this->includeEmpties)
            ? $array
            : Php::arrayWithoutEmpties($array); // TODO: Call another pipe
    }
}
