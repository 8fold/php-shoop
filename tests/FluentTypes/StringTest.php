<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\Helpers\Type;

class StringTest extends TestCase
{
    /**
     * @test
     * The `replace()` method on ESString replaces instances of characters with the given characters. You can also limit the number of replacements made.
     *
     * @return Eightfold\Shoop\FluentTypes\ESString
     */
    public function replace()
    {
        // $base = "Hello, World!";
        // $expected = "Hero, World!";
        // $actual = Shoop::string($base)
        //     ->replace(["ll" => "r"]);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = "abx, xab, bax";
        // $expected = "abc, cab, bac";
        // $actual = Shoop::string($base)->replace(["x" => "c"]);
        // $this->assertEquals($expected, $actual->unfold());
    }

    public function testTrim()
    {
        $base = " \tTrust \n";
        $expected = "Trust";
        $actual = Shoop::string($base)->trim;
        $this->assertEquals($expected, $actual);

        $expected = " \tTrust";
        $actual = Shoop::string($base)->trimUnfolded(false);
        $this->assertEquals($expected, $actual);

        $expected = "Trust \n";
        $actual = Shoop::string($base)->trimUnfolded(true, false);
        $this->assertEquals($expected, $actual);

        $expected = " \tTrust \n";
        $actual = Shoop::string($base)->trimUnfolded(false, false);
        $this->assertEquals($expected, $actual);

        $base = " \tTrust\n ";
        $expected = "\tTrust\n";
        $actual = Shoop::string($base)->trimUnfolded(true, true, " ");
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function read_me()
    {
        // $path = "/Users/8fold/Desktop/ProjectSupreme/SecretFolder/SecretSubfolder";
        // $expected = "/Users/8fold/Documents/ProjectMaxEffort/SecretFolder/SecretSubfolder";

        // $actual = Shoop::string($path)
        //     ->divide("/")
        //     ->minusLast(4)
        //     ->plus("Documents", "ProjectMaxEffort", "SecretFolder", "SecretSubfolder")
        //     ->countIsGreaterThanOrEqualTo(6, function($result, $array) {
        //         return ($result)
        //             ? $array->asString("/")
        //             : "Not the Middle Path.";
        //     });
        // $this->assertEquals($expected, $actual);

        // $parts = explode("/", $path);
        // array_pop($parts); // ../
        // array_pop($parts); // ../
        // array_pop($parts); // ../
        // array_pop($parts); // ../
        // $parts[] = "Documents";
        // $parts[] = "ProjectMaxEffort";
        // $parts[] = "SecretFolder";
        // $parts[] = "SecretSubfolder";
        // if (count($parts) === 6) {
        //     $actual = "/". implode("/", $parts);

        // } else {
        //     $path = "Not the Middle Path.";
        // }
        // $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function replacements()
    {
        // $expected = "Eightfold";
        // $actual = Shoop::this("8fold")->replace(["8" => "Eight"])->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function minus_first()
    {
        // $expected = "Hello!";
        // $doc = <<<EOD

        //     Hello!


        // EOD;
        // $actual = Shoop::this($doc)->minus()->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "Hello!";
        // $html = <<<EOD
        // <p><span><i>Hello!</i></span></p>
        // EOD;
        // $actual = Shoop::this($html)->stripTags()->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "<i>Hello!</i>";
        // $actual = Shoop::this($html)->stripTags("<i>")->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "fold!";
        // $actual = Shoop::this("8fold!")->stripFirst()->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "8fold";
        // $actual = Shoop::this("8fold!")->stripLast()->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "8";
        // $actual = Shoop::this("8fold!")->stripLast(5)->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function transformations()
    {
        // $expected = "8fold";
        // $actual = Php::stringAfterReplacing("Eightfold", ["Eight" => "8"]);
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $expected = "88888888";
        // $actual = Php::stringRepeated("8", 8);
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $expected = "eightfold";
        // $actual = Php::stringToLowercaseFirst("Eightfold");
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $expected = "8fold";
        // $actual = Php::stringToLowercase("8FOLD");
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $expected = "8FOLD";
        // $actual = Php::stringToUppercase("8fold");
        // $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function minus_second()
    {
        // $expected = "8fold";
        // $actual = Php::stringStrippedOfLast("8fold!");
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "8fold";
        // $actual = Php::stringStrippedOfTags("<p><i>8fold</i></p>");
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = "8fold";
        // $actual = Php::stringStrippedOf("!8&f!o\$l)d", false, false, "!&$)");
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $doc = <<<EOD

        //     8fold!

        // EOD;
        // $expected = "8fold!";
        // $actual = Php::stringStrippedOf($doc);
        // $this->assertEqualsWithPerformance($expected, $actual);

        // $this->start = hrtime(true);
        // $expected = <<<EOD

        //     8fold!
        // EOD;
        // $actual = Php::stringStrippedOf($doc, true, false);
        // $this->assertEqualsWithPerformance($expected, $actual, 0.8);

        // $this->start = hrtime(true);
        // $expected = <<<EOD
        // 8fold!

        // EOD;
        // $actual = Php::stringStrippedOf($doc, false, true);
        // $this->assertEqualsWithPerformance($expected, $actual, 0.8);
    }

    /**
     * @test
     */
    public function search()
    {
        // $expected = true;
        // $actual = Php::stringStartsWith("8fold", "8");
        // $this->assertEqualsWithPerformance($expected, $actual, 1.5);

        // // TODO: verify - this seems like it should have failed
        // $this->start = hrtime(true);
        // $expected = false;
        // $actual = Php::stringEndsWith("8fold", "old!");
        // $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function reverse()
    {
        // $expected = "8fold";
        // $actual = Php::stringReversed("dlof8");
        // $this->assertEqualsWithPerformance($expected, $actual, 1);
    }

    /**
     * @test
     */
    public function to_array()
    {
        // $expected = ["8", "f", "o", "l", "d"];
        // $actual = Php::stringToArray("8fold");
        // $this->assertEqualsWithPerformance($expected, $actual);
    }
}
