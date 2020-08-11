<?php

namespace Eightfold\Shoop\Tests\Replace;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Tests\Replace\ESGenericType;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\{ESString};

class ESStringTest extends TestCase
{
    public function test_replacements()
    {
        $expected = "Eightfold";
        $actual = ESString::fold("8fold")->replace(["8" => "Eight"])->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_strippers()
    {
        $expected = "Hello!";
        $doc = <<<EOD

            Hello!


        EOD;
        $actual = ESString::fold($doc)->strip()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "Hello!";
        $html = <<<EOD
        <p><span><i>Hello!</i></span></p>
        EOD;
        $actual = ESString::fold($html)->stripTags()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "<i>Hello!</i>";
        $actual = ESString::fold($html)->stripTags("<i>")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = ESString::fold("8!ifoli!d")->stripAll("!", "i")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "fold!";
        $actual = ESString::fold("8fold!")->stripFirst()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = ESString::fold("8fold!")->stripLast()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "8";
        $actual = ESString::fold("8fold!")->stripLast(5)->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_case_changes()
    {
        $expected = "string";
        $actual = ESString::fold("STRING")->lowercase();
        $this->assertEqualsWithPerformance($expected, $actual->unfold());

        $this->start = hrtime(true);
        $expected = "STRING";
        $actual = ESString::fold("string")->uppercase();
        $this->assertEqualsWithPerformance($expected, $actual->unfold());

        $this->start = hrtime(true);
        $expected = "sTRING";
        $actual = ESString::fold("STRING")->lowerFirst();
        $this->assertEqualsWithPerformance($expected, $actual->unfold());
    }
}
