<?php

namespace Eightfold\Shoop\Tests\Replace;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Tests\Replace\ESGenericType;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\ESString;

class ESStringTest extends TestCase
{
    public function test_countable()
    {
        $expected = 5;
        $actual = ESString::fold("8fold")->integer()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.3);

        $this->start = hrtime(true);
        $actual = ESString::fold("8fold")->count();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_arrayable()
    {
        $expected = ["8", "f", "o", "l", "d"];
        $actual = ESString::fold("8fold")->array()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 3.25);

        $this->start = hrtime(true);
        $expected = true;
        $actual = ESString::fold("8fold")->hasMember(2)->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $count = 0;
        $expected = 5;
        $actual = ESString::fold("8fold");
        foreach($actual as $letter) {
            $count += 1;
        }
        $this->assertEqualsWithPerformance($expected, $count);
        // $this->start = hrtime(true);
        // $expected = "o";
        // $actual = ESString::fold("8fold")->getMember(2)->unfold();
        // $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_rearrange()
    {
        $expected = "8fold";
        $actual = ESString::fold("dlof8")->toggle()->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 3);
    }

    public function test_math_operations()
    {
        $expected = "8fold!";
        $actual = ESString::fold("8fold")->plus("!")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 10.75);

        $this->start = hrtime(true);
        $expected = "8fold";
        $actual = ESString::fold("8!f0o7ld")->minus("!", "7", "0")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 0.7);

        $this->start = hrtime(true);
        $expected = ["", "f", "o", "l", "d"];
        $actual = ESString::fold("8f8o8l8d")->divide("8")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual, 2.25);

        $this->start = hrtime(true);
        $expected = ["f", "o", "l", "d"];
        $actual = ESString::fold("8f8o8l8d")->divide("8", false)->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = "88888888";
        $actual = ESString::fold("8")->multiply(8)->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

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
        $this->assertEqualsWithPerformance($expected, $actual->unfold(), 0.8);

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
