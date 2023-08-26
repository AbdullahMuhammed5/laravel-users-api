<?php

namespace Tests\Unit;

use App\Http\Controllers\DataProviderXAdapter;
use App\Services\ProviderService;
use PHPUnit\Framework\TestCase;

class ProviderServiceTest extends TestCase
{
    public function testGetDataSourcesWithProviderX()
    {
        $providerService = new ProviderService();
        $dataSources = $providerService->getDataFromProviders(ProviderService::PROVIDER_X);

        $this->assertCount(4, $dataSources);
    }

    public function testGetDataSourcesWithProviderY()
    {
        $providerService = new ProviderService();
        $dataSources = $providerService->getDataFromProviders(ProviderService::PROVIDER_Y);

        $this->assertCount(5, $dataSources);
    }

    public function testGetDataSourcesWithNoProvider()
    {
        $providerService = new ProviderService();
        $dataSources = $providerService->getDataFromProviders(null);

        $this->assertCount(9, $dataSources);
    }

    public function testRegisterProvider()
    {
        $providerService = new ProviderService();

        // Create a mock for the DataProviderXAdapter class
        $providerXMock = $this->getMockBuilder(DataProviderXAdapter::class)
            ->getMock();

        // Register the provider
        $providerService->registerProvider(ProviderService::PROVIDER_X, $providerXMock);

        // Use reflection to access the providers property
        $reflectionProviderService = new \ReflectionClass(ProviderService::class);
        $providersProperty = $reflectionProviderService->getProperty('providers');
        $providersProperty->setAccessible(true);

        $providers = $providersProperty->getValue($providerService);

        // Assert that the provider instance is registered correctly
        $this->assertSame($providerXMock, $providers[ProviderService::PROVIDER_X]);
    }
}

