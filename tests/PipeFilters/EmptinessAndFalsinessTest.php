<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use \stdClass;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\Falsifiable;

use Eightfold\Shoop\PipeFilters\AsBoolean;
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
    public function empty_object_is_also_false()
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

        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 2.4);

        $this->start = hrtime(true);
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 0.9);
    }

    public function object_with_public_content_matches_php()
    {
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

        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);

        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool);
    }

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

        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 0.65);

        $this->start = hrtime(true);
        $expected = false;

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance($expected, $bool, 1);
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
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool, 1.3);

        $this->start = hrtime(true);
        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool, 0.9);

        // true
        $using = true;

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

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
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);

        $this->start = hrtime(true);
        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        // true
        $using = 100;

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $this->start = hrtime(true);
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        // $this->start = hrtime(true);
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
        $this->start = hrtime(true);
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        // $this->start = hrtime(true);
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
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool, 0.75);

        $this->start = hrtime(true);
        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool, 0.7);

        // true
        $using = [1];

        // PHP
        $bool = (bool) $using;
        $this->assertTrue($bool);

        $bool = empty($using);
        $this->assertFalse($bool);

        // Shoop
        $this->start = hrtime(true);
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);
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
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);

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
        $this->start = hrtime(true);
        $bool = AsBoolean::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(true, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($using);
        $this->assertEqualsWithPerformance(false, $bool);
    }

    /**
     * @test
     */
    public function json_as_tuple_falsiness_is_inversely_related_to_its_emptiness()
    {
        // false
        $using = '{}';
        $tuple = json_decode($using);

        // PHP
        // true | false
        $bool = (bool) $tuple;
        $this->assertTrue($bool);

        $bool = empty($tuple);
        $this->assertFalse($bool);

        // Shoop
        // false | true - deviation
        $this->start = hrtime(true);
        $expected = false;

        $bool = AsBoolean::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $bool, 1.5);

        $this->start = hrtime(true); // deviation
        $expected = true;

        $bool = IsEmpty::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance($expected, $bool, 0.7);

        // true
        $using = '{"one":1}';
        $tuple = json_decode($using);

        // PHP
        // true | false - no change
        $bool = (bool) $tuple;
        $this->assertTrue($bool);

        $bool = empty($tuple);
        $this->assertFalse($bool);

        // Shoop
        // true | false - no change
        $this->start = hrtime(true);
        $bool = AsBoolean::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance(true, $bool);

        $bool = IsEmpty::apply()->unfoldUsing($tuple);
        $this->assertEqualsWithPerformance(false, $bool);

        // TODO: Consider - see dictionary. Should we allow a member "efToBool"
        //      set to true or false use the falsifiable mechanic?? Is it that
        //      efToBool is the name - or is it that efToBool is the name, and
        //      the content of the member is callable??
    }
}
