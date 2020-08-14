<?php

namespace Eightfold\Shoop\Tests\Replace\Php;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\PipeFilters\IsArray;
use Eightfold\Shoop\PipeFilters\IsDictionary;

/**
 * @group  IsCollectionType
 */
class IsCollecitonTypeTest extends TestCase
{
    /**
     * @test
     */
    public function arrays_are_ordered_sequentially_using_numeric_indeces()
    {
        $expected = true;
        $actual = IsArray::apply()->unfoldUsing([1, 2, 3, 4]);
        $this->assertEqualsWithPerformance($expected, $actual);

        $this->start = hrtime(true);
        $expected = false;
        $actual = IsArray::apply()->unfoldUsing([1, "b" => 2, "8" => 3, 0 => 4]);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = false;
        $actual = IsArray::apply()->unfoldUsing([3 => 1, 2 => 3, 1 => 3, 0 => 4]);
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    /**
     * @test
     */
    public function dictionaries_are_unordered_using_unique_keys()
    {
        $expected = false;
        $actual = IsDictionary::apply()->unfoldUsing([1, 2, 3, 4]);
        $this->assertEqualsWithPerformance($expected, $actual);

        $expected = true;
        $actual = IsDictionary::apply()->unfoldUsing([1, "8" => 2, "8" => 3]);
        $this->assertEqualsWithPerformance($expected, $actual);
    }
}
