<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Contracts\Falsifiable;

use Eightfold\Shoop\PipeFilters\TypeAsBoolean;
use Eightfold\Shoop\PipeFilters\IsEmpty;

/**
 * @group PhpDeviations
 * @group AsBoolean
 * @group IsEmpty
 */
class EmptinessAndFalsinessTest extends TestCase
{
    /**
     * @test
     *
     * In Php, a valid object instance is always `true` and never `empty`. There
     * is no mechanism as of PHP 8.0 for an `object` type to be false; instead,
     * the `null` type is used as a placeholder.
     *
     * In Shoop, we say `null` doesn't exist; rather than it representing
     * that which doesn't exist. Therefore, in Shoop, an object follows the
     * patterns established for `dictionary` in that if a `dictionary` has
     * members, it is true and is not empty. Further, Shoop objects have the
     * ability to say whether they are true or false.
     *
     * The first two characters of the method name are placeholders for a possible
     * future magic method proprosed in PHP RFC: Objects can be declared
     * falsifiable. The `Falsifiable` interface implementation can be found in the
     * Interfaces directory.
     *
     * @see   https://wiki.php.net/rfc/objects-can-be-falsifiable
     */
    public function objects_can_be_inversely_correlated()
    {
        $using = new class {};

        // PHP - true|false
        $bool = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - false|true
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply(),
            0.43
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply(),
            0.71
        )->unfoldUsing($using);

        $using = new class {
            public $property = "8fold";
        };

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = new class implements Falsifiable {
            public $property = "8fold";

            public function asBoolean(): Foldable
            {
                return new class implements Foldable {
                    public function fold($value)
                    {}

                    public function unfold()
                    {}
                };
            }

            public function efToBool(): bool
            {
                return false;
            }
        };

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - false|false
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function boolean_inversely_correlated()
    {
        $using = true;

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertEquals(true, $bool);
        $this->assertEquals(false, $empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function integer_inversely_correlated()
    {
        $using = 0;

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertFalse($bool);
        $this->assertTrue($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply()
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function list_inversely_correlated()
    {
        $using = [];

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertFalse($bool);
        $this->assertTrue($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply(),
            0.34
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = [1];

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = ["one" => 1];

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function tuple_inversely_correlated_deviation()
    {
        $using = new stdClass;

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - false|true
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply(),
            2.39 // unstable
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply(),
            2.53 // unstable
        )->unfoldUsing($using);

        $using = (object) ["public" => true];

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - true|false
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply(),
            0.97
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = new class {
            public $var   = "content";
            private $var2 = "private";
        };

        // PHP
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (no change)
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = '{}';

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - false|true
        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply(),
            1.39
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply()
        )->unfoldUsing($using);

        $using = '{"member":true}';

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (no change) - true|false
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply()
        )->unfoldUsing($using);
    }
}
