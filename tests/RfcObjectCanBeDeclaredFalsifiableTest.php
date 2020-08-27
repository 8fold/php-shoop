<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestClasses\TestCase;
use Eightfold\Shoop\Tests\TestClasses\AssertEquals;

use \stdClass;

use Eightfold\Shoop\Shooped;

use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;
use Eightfold\Shoop\FilterContracts\Interfaces\Emptiable;

use Eightfold\Shoop\Filter\TypeAsBoolean;
use Eightfold\Shoop\Filter\IsEmpty;

/**
 * @group AsBoolean
 * @group IsEmpty
 *
 * In Php, a valid object instance is always `true` and never `empty`. There
 * is no mechanism as of PHP 8.0 for an `object` type to be false; instead,
 * the `null` type is used as a placeholder.
 *
 * In Shoop, we say `null` doesn't exist; rather than it representing
 * being something representing nothing. Therefore, in Shoop, an object
 * follows patterns established for `dictionary` in that if a `dictionary` has
 * members, it is true and is not empty. Further, Shoop objects have the
 * ability to say whether they are true or false.
 *
 * The first two characters of the method name are placeholders for a possible
 * future magic method proprosed in PHP RFC: Objects can be declared
 * falsifiable. The `Falsifiable` interface implementation can be found in
 * `/src/FilterContracts/Interfaces/Falsifiable.php`.
 *
 * @see https://wiki.php.net/rfc/objects-can-be-falsifiable
 */
class RfcObjectCanBeDeclaredFalsifiableTest extends TestCase
{
    /**
     * @test
     */
    public function empty_instance_is_false_and_empty()
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
            0.88 // 0.75 // 0.43
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply(),
            0.71
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function instance_with_public_property_matches_php()
    {
        $using = new class {
            public $property = "8fold";
        };

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop - true|false
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
    public function falsifiable_instance_can_be_false_and_non_empty()
    {
        $using = new class implements Falsifiable {
            public $property = "8fold";

            // Not required or desired for RFC purposes.
            public function asBoolean(): Falsifiable
            {
                return Shooped::fold(false);
            }

            // Would become "__toBool" to match PHP magic method and type
            // reference pattern of truncating "boolean" to "bool," despite
            // gettype() returning "boolean".
            public function efToBoolean(): bool
            {
                return $this->asBoolean()->unfold();
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
            TypeAsBoolean::apply(),
            1.58 // 1.09
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            false,
            IsEmpty::apply(),
            0.73
        )->unfoldUsing($using);
    }

    /**
     * Not related to RFC as submitted; however, is related given the coupling
     * between falsiness and emptiness in PHP.
     *
     * @test
     */
    public function emptiable_instance_can_be_empty_despite_public_properties()
    {
        $using = new class implements Emptiable {
            public $property = "8fold";

            public function isEmpty(): Falsifiable
            {
                return Shooped::fold(true);
            }

            public function efIsEmpty(): bool
            {
                return $this->isEmpty()->unfold();
            }
        };

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - true|true
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply(),
            0.31
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply(),
            1.14 // 1.05 // 1.02
        )->unfoldUsing($using);
    }

    /**
     * Not related to RFC as submitted; however, is related given the coupling
     * between falsiness and emptiness in PHP.
     *
     * @test
     * @group current
     */
    public function instance_can_specify_emptiness_and_falsiness_achieving_false_and_empty()
    {
        $using = new class implements Emptiable {
            public $property = "8fold";

            public function asBoolean(): Falsifiable
            {
                return Shooped::fold(false);
            }

            public function efToBoolean(): bool
            {
                return $this->asBoolean()->unfold();
            }

            public function isEmpty(): Falsifiable
            {
                return Shooped::fold(true);
            }

            public function efIsEmpty(): bool
            {
                return $this->isEmpty()->unfold();
            }
        };

        // PHP - true|false
        $bool  = (bool) $using;
        $empty = empty($using);

        $this->assertTrue($bool);
        $this->assertFalse($empty);

        // Shoop (deviation) - false|true
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply(),
            0.41 // 0.32
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            IsEmpty::apply(),
            1.16
        )->unfoldUsing($using);
    }
}
