<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;

// use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;

use Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Shoop\PipeFilters\TypeAs;

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
    public function empty_class_is_false_and_empty()
    {
        $using = new class {};

        // PHP
        // true | false
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // false | true - deviation
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.2);

        $this->start = hrtime(true);
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

    /**
     * @test
     */
    public function class_with_public_property_true_and_not_empty()
    {
        // tuple
        $using = new class {
            public $property = "8fold";
        };

        // PHP
        // true | false
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // true | false - no change
        $this->start = hrtime(true);
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.35);

        $this->start = hrtime(true);
        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

    /**
     * @test
     */
    public function falsifiable_object_returning_false_is_false_but_not_empty()
    {
        // falsifiable is false
        $using = new class implements Falsifiable {
            public $property = "8fold";

            public function efToBool(): bool
            {
                return false;
            }
        };

        // PHP
        // true | false - is_bool | empty, respectively
        //
        // Shoop
        // false | false - deviation
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.35);

        $this->start = hrtime(true);
        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

    /**
     * @test
     */
    public function bool_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = false;

        // PHP
        $bool = (bool) $using;
        $this->assertFalse($bool);

        $bool = empty($using);
        $this->assertTrue($bool);

        // Shoop
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.4);

        $this->start = hrtime(true);
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        // true
        $using = true;

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);
    }

    /**
     * @test
     */
    public function integer_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = 0;

        // PHP
        $bool = (bool) $using;
        $this->assertFalse($bool);

        $bool = empty($using);
        $this->assertTrue($bool);

        // Shoop
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.3);

        $this->start = hrtime(true);
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        // true
        $using = 100;

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);

        // true
        $using = -100;

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);
    }

    /**
     * @test
     */
    public function array_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = [];

        // PHP
        $bool = (bool) $using;
        $this->assertFalse($bool);

        $bool = empty($using);
        $this->assertTrue($bool);

        // Shoop
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.15);

        $this->start = hrtime(true);
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        // true
        $using = [1];

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // $this->start = hrtime(true);
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

// -> Non-sequential types: most likely should behave similarly

    /**
     * @test
     */
    public function dictionary_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = [];

        // PHP
        $bool = (bool) $using;
        $this->assertFalse($bool);

        $bool = empty($using);
        $this->assertTrue($bool);

        // Shoop
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 2.8);

        $this->start = hrtime(true);
        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        // true
        $using = ["one" => 1];

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // $this->start = hrtime(true);
        $expected = true;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

    /**
     * @test
     */
    public function json_as_tuple_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = '{}';

        // PHP
        // true | false
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // false | true - deviation
        $this->start = hrtime(true);
        $expected = false;

        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 4.1);

        $this->start = hrtime(true); // deviation
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1.3);

        // true
        $using = '{"one":1}';

        // PHP
        // true | false - no change
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        // true | false - no change
        $this->start = hrtime(true);
        $bool = TypeAs::applyWith("boolean")->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);

        // TODO: Consider - see dictionary. Should we allow a member "efToBool"
        //      set to true or false use the falsifiable mechanic?? Is it that
        //      efToBool is the name - or is it that efToBool is the name, and
        //      the content of the member is callable??
    }
}
