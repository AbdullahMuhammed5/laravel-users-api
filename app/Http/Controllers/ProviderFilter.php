<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\FilterInterface;
use Illuminate\Http\Request;

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
