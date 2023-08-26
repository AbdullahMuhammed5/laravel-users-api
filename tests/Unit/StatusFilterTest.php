<?php

namespace Tests\Unit;

use App\Http\Controllers\StatusFilter;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class StatusFilterTest extends TestCase
{
    public function testFilterMethodFiltersDataByStatusCode()
    {
        // Create a mock Request object
        $requestMock = $this->getMockBuilder(Request::class)->getMock();

        // Configure the mock behavior for input('statusCode')
        $requestMock->expects($this->once())
            ->method('input')
            ->with($this->equalTo('statusCode'))
            ->willReturn(2); // Simulate the status code value

        // Create a sample dataset
        $data = [
            ['id' => 1, 'status' => 1],
            ['id' => 2, 'status' => 2],
            ['id' => 3, 'status' => 2],
        ];

        // Create a StatusFilter instance
        $statusFilter = new StatusFilter();

        // Apply the filter
        $filteredData = $statusFilter->filter($data, $requestMock);

        // Assertions
        $this->assertCount(2, $filteredData);
        $this->assertEquals($data[1], $filteredData[0]);
        $this->assertEquals($data[2], $filteredData[1]);
    }
}
