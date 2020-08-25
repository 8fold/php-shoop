<?php

namespace Eightfold\Shoop\Tests\FilterContracts;

use PHPUnit\Framework\TestCase;

use \ReflectionClass;
use \ReflectionMethod;

abstract class FilterContractsTestCase extends TestCase
{
    abstract static public function sutClassName(): string;

    /**
     * Ignore these methods because they are either value holders, use the basic
     * implementation from Shoop pipes, is covered by another set of test cases,
     * or some combination thereof.
     */
    static protected function ignoreClassMethods()
    {
        return [
            "args", // value method, returns args following or incl. main
        ];
    }

    /**
     * @test
     */
    public function case_exists_for_each_method()
    {
        $caseMethods = array_map(
            function($reflectionMethod) {
                if (! in_array($reflectionMethod->name, ["setUp", "testsExistForEachMethod"]) and
                    $reflectionMethod->class === static::class
                ) {
                    if ($reflectionMethod->name === "_at") {
                        return "at";
                    }
                    return $reflectionMethod->name;
                }
            },
            (new ReflectionClass(static::sutClassName()))->getMethods(ReflectionMethod::IS_PUBLIC),
        );
        $caseMethods = array_values(array_filter($caseMethods));

        $sutMethods = array_map(
            function($reflectionMethod) {
                if (! in_array($reflectionMethod->name, static::ignoreClassMethods()) and
                    $reflectionMethod->name[0] !== "_"
                ) {
                    return $reflectionMethod->name;
                }
            },
            (new ReflectionClass(static::sutClassName()))
                ->getMethods(ReflectionMethod::IS_PUBLIC),
        );
        $sutMethods = array_values(array_filter($sutMethods));
        $sutMethods[] = "php_iterator";

        $notTested = array_diff($sutMethods, $caseMethods);
        sort($notTested);
        $notTestedString = print_r($notTested, true);
        $this->assertEquals(0, count($notTested), "The following methods have not been tested (only whether a test method exists): {$notTestedString}");
    }
}
