<?php

namespace App\Http\Controllers;

use App\Services\ProviderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private ProviderService $providerService) { }

    public function getUsers(Request $request): JsonResponse {
        $data = $this->providerService->getDataFromProviders($request->input('provider'));

        $filterContext = new FilterContext();
        $filterContext->addFilter(new StatusFilter());
        $filterContext->addFilter(new BalanceFilter());
        $filterContext->addFilter(new CurrencyFilter());

        $filteredData = $filterContext->filter($data, $request);
        return response()->json(["data" => $filteredData]);
    }
}
