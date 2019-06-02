<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    ESString,
    ESArray
};

use Eightfold\Shoop\Tests\String\TestStrings;

class StringTest extends TestCase
{
    use TestStrings;

    // TODO: Write tests for random character

    public function testCanDoPlusAndMinus()
    {
        $result = ESString::wrap("Hello, ")->plus("🌍!")->unwrap();
        $this->assertEquals($this->plainTextWithUnicode(), $result);

        $result = ESString::wrap("Hello, World!")->minus("l")->unwrap();
        $this->assertEquals("Heo, Word!", $result);
    }

    public function testCanCountContents()
    {
        $result = ESString::wrap("Hello!")->count()->unwrap();
        $this->assertEquals(6, $result);

        $result = ESString::wrap("Hello!")->enumerated()->count()->unwrap();
        $this->assertEquals(6, $result);
    }

    public function testCanBeDvidedBy()
    {
        $compare = ESArray::wrap("He", "o, Wor", "d!");
        $result = ESString::wrap("Hello, World!")
            ->dividedBy("l");
        $this->assertEquals($compare->unwrap(), $result->unwrap());
        $this->assertTrue($result->isSameAs($compare)->unwrap());

        $result = ESString::wrap("Hello, World!")
            ->split("l");
        $compare = ESString::wrap("Heo, Word!");
        $this->assertEquals($compare->unwrap(), $result->joined()->unwrap());

        $compare = ESString::wrap("Heto, Wortd!");
        $this->assertEquals($compare->unwrap(), $result->joined("t")->unwrap());
    }
}
