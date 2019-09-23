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
        $hello = ESString::fold("Hello, ");
        $helloWorld = ESString::fold("Hello, World!");
        $result = $hello->plus("🌍!")->unfold();
        $this->assertEquals($this->plainTextWithUnicode(), $result);

        $result = $helloWorld->minus("l")->unfold();
        $this->assertEquals("Heo, Word!", $result);

        $result = $hello->append("World!");
        $this->assertEquals($helloWorld, $result);

        $result = ESString::fold(", World!")->prependUnfolded("Hello");
        $this->assertEquals($helloWorld, $result);
    }

    public function testCanCountContents()
    {
        $string = ESString::fold("Hello!");
        $result = $string->count()->unfold();
        $this->assertEquals(6, $result);

        $result = $string->enumerated()->count()->unfold();
        $this->assertEquals(6, $result);

        $result = $string->countIsGreaterThanUnfolded(0);
        $this->assertTrue($result);

        $result = $string->countIsNotGreaterThan(8)->unfold();
        $this->assertTrue($result);

        $result = $string->countIsLessThanUnfolded(5);
        $this->assertFalse($result);

        $result = $string->countIsNotLessThanUnfolded(7);
        $this->assertFalse($result);
    }

    public function testCanBeDvidedBy()
    {
        $compare = ESArray::fold(["He", "o, Wor", "d!"]);
        $result = ESString::fold("Hello, World!")
            ->dividedBy("l");
        $this->assertEquals($compare->unfold(), $result->unfold());
        $this->assertTrue($result->isSame($compare)->unfold());

        $result = ESString::fold("Hello, World!")
            ->split("l");
        $compare = ESString::fold("Heo, Word!");
        $this->assertEquals($compare->unfold(), $result->join());

        $compare = ESString::fold("Heto, Wortd!");
        $this->assertEquals($compare->unfold(), $result->join("t")->unfold());
    }

    public function testDoesBeginOrEndWith()
    {
        $helloWorld = ESString::fold("Hello, World!");
        $result = $helloWorld->beginsWithUnfolded("Hello");
        $this->assertTrue($result);

        $result = $helloWorld->endsWithUnfolded("World!");
        $this->assertTrue($result);
    }
}
