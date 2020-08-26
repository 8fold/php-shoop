<?php

namespace Eightfold\Shoop\Tests\FilterContracts\ContractTests;

use Eightfold\Shoop\Tests\FilterContracts\ClassShooped;

trait Foldable
{
    /**
     * @test
     */
    public function fold()
    {
        $expected = false;
        $instance = ClassShooped::fold($expected);
        $actual   = $instance->args(true)[0];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function unfold()
    {
        $expected = true;
        $actual   = ClassShooped::fold($expected)->unfold();
        $this->assertEquals($expected, $actual);
    }
}
