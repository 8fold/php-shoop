<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Minus;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class FromString extends Filter
{
    private $charMask  = [" ", "\t", "\n", "\r", "\0", "\x0B"];

    private $all             = false;
    private $fromStartAndEnd = true;
    private $fromStart       = true;
    private $fromEnd         = true;

    static public function applyWith(...$args)
    {
        $fromStart = (isset($args[0]) and IsBoolean::apply()->unfoldUsing($args[0]))
            ? $args[0]
            : true;

        $fromEnd = (isset($args[1]) or IsBoolean::apply()->unfoldUsing($args[1]))
            ? $args[1]
            : true;

        $charMask = (isset($args[2]) and IsList::apply()->unfoldUsing($args[2]))
            ? $args[2]
            : [" ", "\t", "\n", "\r", "\0", "\x0B"];

        return new static($fromStart, $fromEnd, $charMask);
    }

    // TODO: PHP 8.0 - array|null
    public function __construct(
        bool $fromStart = true,
        bool $fromEnd   = true,
        array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"]
    )
    {
        $this->fromStartAndEnd = ($fromStart and $fromEnd) ? true : false;
        $this->fromStart       = $fromStart;
        $this->fromEnd         = $fromEnd;
        $this->all             = (! $fromStart and ! $fromEnd) ? true : false;
        $this->charMask        = $charMask;
    }

    public function __invoke(string $using): string
    {
        if ($this->fromStartAndEnd) {
            $charMask = AsStringFromList::apply()->unfoldUsing($this->charMask);
            return trim($using, $charMask);

        } elseif ($this->fromStart) {
            $charMask = AsStringFromList::apply()->unfoldUsing($this->charMask);
            return ltrim($using, $charMask);

        } elseif ($this->fromEnd) {
            $charMask = AsStringFromList::apply()->unfoldUsing($this->charMask);
            return rtrim($using, $charMask);

        } elseif ($this->all) {
            return str_replace($this->charMask, "", $using);

        }
    }
}
