<?php

namespace App\Filters;

use App\Http\Interfaces\FilterInterface;

class ProviderFilter implements FilterInterface
{
    public function filter($data, $request) {
        $provider = $request->input('provider');

        if ($provider) {
            $data = array_filter($data, function($item) use ($provider) {
                return $item['provider'] == $provider;
            });
        }

        return array_values($data);
    }
}
