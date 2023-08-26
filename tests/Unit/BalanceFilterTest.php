<?php

namespace Tests\Unit;

use App\Filters\BalanceFilter;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class BalanceFilterTest extends TestCase
{
    public function testFilterMethodFiltersDataByBalanceRange()
    {
        // Create a mock Request object
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        // Configure the mock behavior for input('balanceMin') and input('balanceMax')
        $requestMock->expects($this->exactly(2))
            ->method('input')
            ->withConsecutive(
                [$this->equalTo('balanceMin')],
                [$this->equalTo('balanceMax')]
            )
            ->willReturn(1000, 50000); // Simulate the balance range

        // Create a sample dataset
        $data = [
            ['id' => 1, 'amount' => 500],
            ['id' => 2, 'amount' => 1500],
            ['id' => 3, 'amount' => 25000],
            ['id' => 4, 'amount' => 75000],
        ];

        // Create a BalanceFilter instance
        $balanceFilter = new BalanceFilter();

        // Apply the filter
        $filteredData = $balanceFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(2, $filteredData);
        $this->assertEquals($data[1], $filteredData[0]);
        $this->assertEquals($data[2], $filteredData[1]);
    }

    public function testFilterMethodHandlesDefaultMaxBalance()
    {
        // Create a mock Request object with only 'balanceMin'
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        // Configure the mock behavior for input('balanceMin') and input('balanceMax')
        $requestMock->expects($this->exactly(2))
            ->method('input')
            ->withConsecutive(
                [$this->equalTo('balanceMin')],
                [$this->equalTo('balanceMax')]
            )
            ->willReturn(200, null); // Simulate balanceMin

        // Create a sample dataset
        $data = [
            ['id' => 1, 'amount' => 100],
            ['id' => 2, 'amount' => 250],
            ['id' => 3, 'amount' => 3000],
            ['id' => 4, 'amount' => 800000],
        ];

        // Create a BalanceFilter instance
        $balanceFilter = new BalanceFilter();

        // Apply the filter
        $filteredData = $balanceFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(3, $filteredData);
        $this->assertEquals($data[1], $filteredData[0]);
        $this->assertEquals($data[2], $filteredData[1]);
        $this->assertEquals($data[3], $filteredData[2]);
    }

    public function testFilterMethodHandlesDefaultMinBalance()
    {
        // Create a mock Request object with only 'balanceMin'
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        // Configure the mock behavior for input('balanceMin') and input('balanceMax')
        $requestMock->expects($this->exactly(2))
            ->method('input')
            ->withConsecutive(
                [$this->equalTo('balanceMin')],
                [$this->equalTo('balanceMax')]
            )
            ->willReturn(null, 800000); // Simulate balanceMax

        // Create a sample dataset
        $data = [
            ['id' => 1, 'amount' => 100],
            ['id' => 2, 'amount' => 250],
            ['id' => 3, 'amount' => 3000],
            ['id' => 4, 'amount' => 8000000],
        ];

        // Create a BalanceFilter instance
        $balanceFilter = new BalanceFilter();

        // Apply the filter
        $filteredData = $balanceFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(3, $filteredData);
        $this->assertEquals($data[0], $filteredData[0]);
        $this->assertEquals($data[1], $filteredData[1]);
        $this->assertEquals($data[2], $filteredData[2]);
    }
}

