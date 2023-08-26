<?php

namespace App\Filters;

use App\Http\Interfaces\FilterInterface;

class CurrencyFilter implements FilterInterface {
    public function filter($data, $request) {
        $currency = $request->input('currency');

        if ($currency) {
            $data = array_filter($data, function($item) use ($currency) {
                return $item['currency'] == $currency;
            });
        }

        return array_values($data);
    }
}
