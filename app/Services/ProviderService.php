<?php

namespace App\Services;

use App\Adapters\DataProviderXAdapter;
use App\Adapters\DataProviderYAdapter;
use App\Http\Interfaces\DataSourceInterface;

class ProviderService
{
    const PROVIDER_X = "DataProviderX";
    const PROVIDER_Y = "DataProviderY";
    private array $providers = [];

    public function getDataFromProviders(?string $provider): array {
        switch ($provider){
            case self::PROVIDER_X:
                $this->registerProvider(self::PROVIDER_X, new DataProviderXAdapter());
                break;
            case self::PROVIDER_Y:
                $this->registerProvider(self::PROVIDER_Y, new DataProviderYAdapter());
                break;
            default:
                $this->registerProvider(self::PROVIDER_X, new DataProviderXAdapter());
                $this->registerProvider(self::PROVIDER_Y, new DataProviderYAdapter());
        }

        return $this->getDataSources();
    }

    public function registerProvider(string $providerName, $providerInstance): void {
        $this->providers[$providerName] = $providerInstance;
    }

    public function getDataSources(): array {
        $dataSources = [];

        foreach ($this->providers as $provider) {
            if ($provider instanceof DataSourceInterface) {
                $dataSources = array_merge($dataSources, $provider->getData());
            }
        }

        return $dataSources;
    }
}
