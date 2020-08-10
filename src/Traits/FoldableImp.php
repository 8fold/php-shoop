<?php

namespace Eightfold\Shoop\Traits;

use \Closure;

use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpMagicMethodsImp;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Interfaces\Foldable;

trait FoldableImp
{
    use PhpMagicMethodsImp;

    protected $main;
    protected $args;

    static public function fold($main, ...$args): Foldable
    {
        return new static($main, ...$args);
    }

    static public function processedArgs(...$args): array
    {
        return $args;
    }

    /**
     * Try not to override this.
     *
     * If you do, be sure to store both `main` and `args` to avoid unintended
     * errors.
     */
    public function __construct($main, ...$args)
    {
        $this->main = (method_exists($this, "processedMain"))
            ? static::processedMain($main)
            : $main;
        $this->args = static::processedArgs(...$args);
    }

    public function main()
    {
        return $this->main;
    }

    public function args(): array
    {
        return $this->args;
    }

    public function unfold()
    {
        // Preserve Shoop internally: unfold($preserve = false)
        // only implement if needed; otherwise, we're good.
        $return = (isset($this->temp)) ? $this->temp : $this->main();
        if (Type::isArray($return) || Type::isDictionary($return)) {
            $array = $return;
            $return = [];
            foreach ($array as $member => $value) {
                if (Type::isFoldable($value)) {
                    $value = $value->unfold();
                }
                $return[$member] = $value;
            }
        }
        return $return;
    }

    public function condition($bool, Closure $closure = null)
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        $value = $this->main();
        if ($closure === null) {
            $closure = function($bool, $value) {
                return $bool;
            };
        }
        return $closure($bool, static::fold($value, ...$this->args()));
    }
}
