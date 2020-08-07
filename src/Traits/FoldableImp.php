<?php

namespace Eightfold\Shoop\Traits;

use \Closure;

use Eightfold\Shoop\Traits\ShoopedImpExtensions\PhpMagicMethodsImp;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

trait FoldableImp
{
    use PhpMagicMethodsImp;

    /**
     * @deprecated
     */
    protected $value;

    protected $main;
    protected $args;

    static public function fold($main, ...$args)
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
        $this->main = $main;
        $this->args = $args;
    }

    public function main()
    {
        return $this->main;
    }

    public function args()
    {
        return $this->args;
    }

    /**
     * @deprecated
     */
    public function value()
    {
        return $this->main();
        return $this->value;
    }

    public function unfold()
    {
        // Preserve Shoop internally: unfold($preserve = false)
        // only implement if needed; otherwise, we're good.
        $return = (isset($this->temp)) ? $this->temp : $this->value;
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
        $value = $this->value();
        if ($closure === null) {
            $closure = function($bool, $value) {
                return $bool;
            };
        }
        return $closure($bool, Shoop::this($value));
    }
}
