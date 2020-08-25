<?php

namespace Eightfold\Shoop\FluentTypes\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use \ReflectionClass;
use \ReflectionMethod;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESString;
use Eightfold\Shoop\FluentTypes\ESTuple;

/**
 * @group ArrayFluentUnit
 */
class ArrayTest extends TestCase
{
    /**
     * @test
     */
    public function asArray(): void
    {
        AssertEqualsFluent::applyWith(
            [1, 2, 3],
            ESArray::class,
            13.15
        )->unfoldUsing(
            Shoop::this([1, 2, 3])->asArray()
        );
    }

    /**
     * @test
     */
    public function asBoolean(): void
    {
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class,
            3.64
        )->unfoldUsing(
            Shoop::this([])->asBoolean()
        );
    }

    /**
     * @test
     */
    public function asDictionary(): void
    {
        AssertEqualsFluent::applyWith(
            ["i0" => "a", "i1" => "b"],
            ESDictionary::class,
            0.48
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asDictionary()
        );
    }

    /**
     * @test
     */
    public function asInteger(): void
    {
        AssertEqualsFluent::applyWith(
            2,
            ESInteger::class,
            0.43
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asInteger()
        );
    }

    /**
     * @test
     */
    public function asJson(): void
    {
        AssertEqualsFluent::applyWith(
            '{"i0":"a","i1":"b"}',
            ESJson::class,
            1.44
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asJson()
        );
    }

    /**
     * @test
     */
    public function asString(): void
    {
        AssertEqualsFluent::applyWith(
            "ab",
            ESString::class,
            1.36
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asString()
        );
    }

    /**
     * @test
     */
    public function asTuple(): void
    {
        AssertEqualsFluent::applyWith(
            (object) ["i0" => "a", "i1" => "b"],
            ESTuple::class,
            1.15
        )->unfoldUsing(
            Shoop::this(["a", "b"])->asTuple()
        );
    }

    public function setUp(): void
    {
        $this->caseExistForEachMethod();
    }

    public function caseExistForEachMethod()
    {
        $caseMethods = array_map(
            function($reflectionMethod) {
                if (! in_array($reflectionMethod->name, ["setUp", "testsExistForEachMethod"]) and
                    $reflectionMethod->class === static::class
                ) {
                    return $reflectionMethod->name;
                }
            },
            (new ReflectionClass(static::class))->getMethods(ReflectionMethod::IS_PUBLIC),
        );
        $caseMethods = array_values(array_filter($caseMethods));

        $sutMethods = array_map(
            function($reflectionMethod) {
                if (! in_array($reflectionMethod->name, $this->ignoreClassMethods()) and
                    $reflectionMethod->name[0] !== "_"
                ) {
                    return $reflectionMethod->name;
                }
            },
            (new ReflectionClass(ESArray::class))->getMethods(ReflectionMethod::IS_PUBLIC),
        );
        $sutMethods = array_values(array_filter($sutMethods));
        $sutMethods[] = "php_iterator";

        $notTested = array_diff($sutMethods, $caseMethods);
        sort($notTested);
        $notTestedString = print_r($notTested, true);
        $this->assertEquals(0, count($notTested), "The following methods have not been tested (only whether a test method exists): {$notTestedString}");
    }

    /**
     * Ignore these methods because they are either value holders, use the basic
     * implementation from Shoop pipes, is covered by another set of test cases,
     * or some combination thereof.
     */
    private function ignoreClassMethods()
    {
        return [
            "args",           // value method, returns args following or incl. main
            "efToArray",      // uses Shoop default (asArray)
            "efToBoolean",    // uses Shoop default (asBoolean)
            "efToDictionary", // uses Shoop default (asDictionary)
            "efToInteger",    // uses Shoop default (asInteger)
            "efToJson",       // uses Shoop default (asJson)
            "efToString",     // uses Shoop default (asJson)
            "efToTuple",      // uses Shoop default (asJson)
            "fold",           // uses Foldable default
            "count",          // uses Shoop default (efToInteger)
            "jsonSerialize",  // uses Shoop default (efToTuple)
            "offsetExists",   // uses Shoop default (hasMember)
            "offsetGet",      // uses Shoop default (at)
            "offsetSet",      // uses Shoop default (plusMember ??) TODO: Should plus() be solely for values
            "offsetUnset",    // uses Shoop default (minusMember)
            "unfold",         // uses Foldable default
            "rewind",         // part of php_iterator
            "valid",          // part of php_iterator
            "current",        // part of php_iterator
            "key",            // part of php_iterator
            "next",           // part of php_iterator
        ];
    }
}
