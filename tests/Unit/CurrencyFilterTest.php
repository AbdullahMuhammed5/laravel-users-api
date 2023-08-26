<?php

namespace Tests\Unit;

use App\Http\Controllers\CurrencyFilter;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CurrencyFilterTest extends TestCase
{
    public function testFilterMethodFiltersDataByCurrency()
    {
        // Create a mock Request object
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        // Configure the mock behavior for input('currency')
        $requestMock->expects($this->once())
            ->method('input')
            ->with($this->equalTo('currency'))
            ->willReturn('USD'); // Simulate the currency

        // Create a sample dataset
        $data = [
            ['id' => 1, 'currency' => 'USD'],
            ['id' => 2, 'currency' => 'EUR'],
            ['id' => 3, 'currency' => 'USD'],
        ];

        // Create a CurrencyFilter instance
        $currencyFilter = new CurrencyFilter();

        // Apply the filter
        $filteredData = $currencyFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(2, $filteredData);
        $this->assertEquals($data[0], $filteredData[0]);
        $this->assertEquals($data[2], $filteredData[1]);
    }

    public function testFilterMethodHandlesNoCurrency()
    {
        // Create a mock Request object with no input('currency')
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();

        // Configure the mock behavior for input('currency')
        $requestMock->expects($this->once())
            ->method('input')
            ->with($this->equalTo('currency'))
            ->willReturn(null); // Simulate no currency

        // Create a sample dataset
        $data = [
            ['id' => 1, 'currency' => 'USD'],
            ['id' => 2, 'currency' => 'EUR'],
            ['id' => 3, 'currency' => 'USD'],
        ];

        // Create a CurrencyFilter instance
        $currencyFilter = new CurrencyFilter();

        // Apply the filter
        $filteredData = $currencyFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(3, $filteredData);
        $this->assertEquals($data, $filteredData);
    }
}
