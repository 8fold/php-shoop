<?php

namespace Eightfold\Shoop\Tests\Order;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Type;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `sort()` method sorts the array representation of the `Shoop type`. It accepts two arguments, the first argument specifies whether to sort ascending or descending (ascending is the default), the second argument specifies whether to sort the valuea or keys/members (values is the default).
 */
class SortTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray
     */
    public function testESArray()
    {
        $expected = ["Alpha", "Beta", "Gamma", "alpha", "beta", "gamma"];
        $actual = Shoop::array(["beta", "Alpha", "gamma", "Beta", "alpha" , "Gamma"])->sort();
        $this->assertEquals($expected, $actual->unfold());

        $expected = ["gamma", "beta", "alpha", "Gamma", "Beta", "Alpha"];
        $actual = Shoop::array(["beta", "Alpha", "gamma", "Beta", "alpha" , "Gamma"])->sort(false);
        $this->assertEquals($expected, $actual->unfold());

        $expected = ["Alpha", "alpha", "beta", "Beta", "gamma", "Gamma"];
        $actual = Shoop::array(["beta", "Alpha", "gamma", "Beta", "alpha" , "Gamma"])->sort(true, false);
        $this->assertEquals($expected, $actual->unfold());

        rsort($expected, SORT_NATURAL | SORT_FLAG_CASE);
        $actual = Shoop::array(["beta", "Alpha", "gamma", "Beta", "alpha" , "Gamma"])->sort(false, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not Could be a random boolean generator
     */
    public function testESBool()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\ESDictionary
     */
    public function testESDictionary()
    {
        $expected = ["gamma" => "Alpha", "beta" => "Beta", "alpha" => "beta", "delta" => "alpha"];
        $actual = Shoop::dictionary(["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"])->sort();
        $this->assertEquals($expected, $actual->unfold());

        arsort($expected);
        $actual = Shoop::dictionary(["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"])->sort(false);
        $this->assertEquals($expected, $actual->unfold());

        $expected = ["gamma" => "Alpha", "delta" => "alpha", "beta" => "Beta", "alpha" => "beta"];
        $actual = Shoop::dictionary(["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"])->sort(true, false);
        $this->assertEquals($expected, $actual->unfold());

        arsort($expected, SORT_FLAG_CASE);
        $actual = Shoop::dictionary(["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"])->sort(false, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @not Could sort the range
     */
    public function testESInt()
    {
        $this->assertFalse(false);
    }

    /**
     * @see ESObject->sort()
     *
     * @return Eightfold\Shoop\ESJson After converting the JSON string to an ESObject.
     */
    public function testESJson()
    {
        $baseExpected = ["gamma" => "Alpha", "beta" => "Beta", "delta" => "alpha", "alpha" => "beta"];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha","beta":"Beta","delta":"alpha","alpha":"beta"}')->sort();
        $this->assertEquals($expected, $actual->unfold());

        $baseExpected = [ "alpha" => "beta", "delta" => "alpha", "beta" => "Beta", "gamma" => "Alpha"];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha","beta":"Beta","delta":"alpha","alpha":"beta"}')->sort(false);
        $this->assertEquals($expected, $actual->unfold());

        $baseExpected = ["gamma" => "Alpha", "delta" => "alpha", "beta" => "Beta", "alpha" => "beta"];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha", "beta":"Beta", "delta":"alpha", "alpha":"beta"}')->sort(true, false);
        $this->assertEquals($expected, $actual->unfold());

        $baseExpected = ["beta" => "Beta", "alpha" => "beta", "gamma" => "Alpha", "delta" => "alpha"];
        $expected = json_encode($baseExpected);
        $actual = Shoop::json('{"gamma":"Alpha", "beta":"Beta", "delta":"alpha", "alpha":"beta"}')->sort(false, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESObject
     */
    public function testESObject()
    {
        $expected = (object) ["gamma" => "Alpha", "delta" => "alpha", "beta" => "Beta", "alpha" => "beta"];
        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($object)->sort();
        $this->assertEquals($expected, $actual->unfold());

        $expected = (object) ["beta" => "Beta", "alpha" => "beta", "gamma" => "Alpha", "delta" => "alpha"];
        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($object)->sort(false);
        $this->assertEquals($expected, $actual->unfold());

        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($object)->sort(true, false);
        $this->assertEquals($expected, $actual->unfold());

        $expected = (object) ["beta" => "Beta", "alpha" => "beta", "gamma" => "Alpha", "delta" => "alpha"];
        $object = new \stdClass();
        $object->gamma = "Alpha";
        $object->beta = "Beta";
        $object->delta = "alpha";
        $object->alpha = "beta";
        $actual = Shoop::object($expected)->sort(false, false);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return Eightfold\Shoop\ESString After sorting the individual characters of the original string.
     */
    public function testESString()
    {
        $expected = "aahlp";
        $actual = Shoop::string("alpha")->sort();
        $this->assertEquals($expected, $actual->unfold());
    }
}
