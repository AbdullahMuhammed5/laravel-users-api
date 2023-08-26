<?php

namespace Tests\Unit;

use App\Filters\FilterContext;
use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class FilterContextTest extends TestCase
{
    public function testFilterMethodAppliesFilters()
    {
        // Create a mock of the FilterInterface
        $filterMock = $this->createMock(FilterInterface::class);

        // Configure the mock behavior
        $filterMock->expects($this->exactly(2)) // Expects to be called twice
            ->method('filter') // Expects the filter method to be called
            ->willReturnCallback(function ($data, $request) {
                // Simulate a filter's behavior
                return $data . ' filtered';
            });

        // Create a FilterContext instance
        $filterContext = new FilterContext();

        // Add the mock filter to the context
        $filterContext->addFilter($filterMock);
        $filterContext->addFilter($filterMock);

        // Simulate input data and request
        $data = 'original data';
        $request = new Request();

        // Apply filters using the filter method
        $filteredData = $filterContext->filter($data, $request);

        // Assertions
        $this->assertEquals('original data filtered filtered', $filteredData);
    }
}
