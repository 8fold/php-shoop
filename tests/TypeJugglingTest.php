<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

class TypeJugglingTest extends TestCase
{
    public function testJugglingString()
    {
    	$base = "Hello, World!";
    	$string = Shoop::string($base);
    	$this->assertEquals($base, $string->unfold());

    	// $array = $string->array();
    	// $arrayString = ["H", "e", "l", "l", "o", ",", " ", "W", "o", "r", "l", "d", "!"];
    	// $this->assertEquals($arrayString, $array->unfold());

    	// $dict = $string->dictionary();
    	// $this->assertEquals([
     //        'i0' => 'H',
     //        'i1' => 'e',
     //        'i2' => 'l',
     //        'i3' => 'l',
     //        'i4' => 'o',
     //        'i5' => ',',
     //        'i6' => ' ',
     //        'i7' => 'W',
     //        'i8' => 'o',
     //        'i9' => 'r',
     //        'i10' => 'l',
     //        'i11' => 'd',
     //        'i12' => '!'
     //    ], $dict->unfold());

    	// $object = $string->object();
    	// $this->assertEquals($base, $object->scalar);

     //    $sInt = "05";
    	// $int = Shoop::string($sInt)->int();
    	// $this->assertEquals(5, $int->unfold());

    	$bool = $string->bool();
    	$this->assertEquals(true, $bool->unfold());

    	// $bool = Shoop::string("")->bool();
    	// $this->assertEquals(false, $bool->unfold());
    }

    public function testJugglingArray()
    {
    	$base = [1, 2, 3];
    	$array = Shoop::array($base);
    	$this->assertEquals($base, $array->unfold());

        $expected = "Array([0] => 1, [1] => 2, [2] => 3)";
        $string = $array->string();
        $this->assertEquals($expected, $string->unfold());

    	// $dict = $array->dictionary();
    	// $this->assertEquals([
     //        'i0' => 1,
     //        'i1' => 2,
     //        'i2' => 3
     //    ], $dict->unfold());

    	// $object = $array->object();
    	// $this->assertEquals($base[0], $object->{"0"});

    	$int = $array->int();
    	$this->assertEquals(3, $int->unfold());

    	$bool = $array->bool();
    	$this->assertEquals(true, $bool->unfold());

    	$bool = Shoop::array([])->bool();
    	$this->assertEquals(false, $bool->unfold());
    }

    public function testJugglingBool()
    {
    	$base = true;
    	$bool = Shoop::bool($base);
    	$this->assertEquals($base, $bool->unfold());

    	$string = $bool->string();
    	$this->assertEquals("true", $string->unfold());

    	$string = Shoop::bool(false)->string();
    	$this->assertEquals("", $string->unfold());

    	$dict = $bool->dictionary();
    	$this->assertEquals(
    		["true" => true, "false" => false],
    		$dict->unfold()
    	);

    	$this->assertEquals(
			["true" => false, "false" => true],
    		$bool->toggle()->dictionary()->unfold()
    	);

    	// $object = $bool->object();
    	// $this->assertEquals(true, $object->true);

    	$int = $bool->int();
    	$this->assertEquals(1, $int->unfold());

    	$self = $bool->bool();
    	$this->assertEquals(true, $self->unfold());

    	$array = $bool->array();
    	$this->assertEquals([true], $array->unfold());
    }

    public function testJugglingInt()
    {
    	$base = 4;
    	$int = Shoop::int($base);
    	$this->assertEquals($base, $int->unfold());

    	// $array = $int->array();
    	// $this->assertEquals([0, 1, 2, 3, 4], $array->unfold());

    	// $string = $int->string();
    	// $this->assertEquals("4", $string->unfold());

    	// $dict = $int->dictionary();
    	// $this->assertEquals([
     //        'i0' => 0,
     //        'i1' => 1,
     //        'i2' => 2,
     //        'i3' => 3,
     //        'i4' => 4
     //    ], $dict->unfold());

    	// $object = $int->object();
    	// $this->assertEquals($base, $object->scalar);

    	$int = $int->int();
    	$this->assertEquals(4, $int->unfold());

    	$bool = $int->bool();
    	$this->assertEquals(true, $bool->unfold());

    	$bool = Shoop::int(0)->bool();
    	$this->assertEquals(false, $bool->unfold());
    }

    public function testJugglingDictionary()
    {
    	$base = ["one" => 1, "two" => 2];
    	$dict = Shoop::dictionary($base);
    	$this->assertEquals($base, $dict->unfold());

    	$array = $dict->array();
    	$this->assertEquals([1, 2], $array->unfold());

    	$string = $dict->string();
    	$this->assertEquals("Array([one] => 1, [two] => 2)", $string->unfold());

    	$dict = $dict->dictionary();
    	$this->assertEquals($base, $dict->unfold());

    	// $object = $dict->object();
    	// $this->assertEquals(1, $object->one);

    	$int = $dict->int();
    	$this->assertEquals(2, $int->unfold());

    	$bool = $dict->bool();
    	$this->assertEquals(true, $bool->unfold());

    	$bool = Shoop::dictionary([])->bool();
    	$this->assertEquals(false, $bool->unfold());
    }

    public function testJugglingObject()
    {
    	$base = (object) ["one" => 1, "two" => 2];
    	$obj = Shoop::object($base);
    	$this->assertEquals($base, $obj->unfold());

    	$array = $obj->array();
    	$this->assertEquals([1, 2], $array->unfold());

    	// $string = $obj->string();
    	// $this->assertEquals("stdClass Object([one] => 1, [two] => 2)", $string->unfold());

    	$dict = $obj->dictionary();
    	$this->assertEquals((array) $base, $dict->unfold());

    	// $object = $obj->object();
    	// $this->assertEquals(1, $object->one);

    	$int = $obj->int();
    	$this->assertEquals(2, $int->unfold());

    	$bool = $obj->bool();
    	$this->assertEquals(true, $bool->unfold());

    	$emptyObj = new \stdClass();
    	$bool = Shoop::object($emptyObj)->bool();
    	$this->assertEquals(false, $bool->unfold());
    }
}
