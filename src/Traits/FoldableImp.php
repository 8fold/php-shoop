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

    /**
     * @deprecated
     */
    protected $value;

    protected $main;
    protected $args;

    static public function fold($main, ...$args): Foldable
    {
        return new static($main, ...$args);
    }

    /**
     * Try not to override this.
     *
     * If you do, be sure to store both `main` and `args` to avoid unintended
     * errors.
     */
    public function __construct($main, ...$args)
    {
        if (method_exists($this, "processedMain")) {
            $this->main = static::processedMain($main);

        } else {
            $this->main = $main;

        }
        $this->args = $args;
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
                if (Type::isShooped($value)) {
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
        return $closure($bool, Shoop::this($value));
    }
}
