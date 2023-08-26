<?php

namespace App\Filters;

use App\Http\Interfaces\FilterInterface;

class BalanceFilter implements FilterInterface {
    const DEFULT_MAX_BALANCE = 1000000;
    public function filter($data, $request) {
        $balanceMin = $request->input('balanceMin') ?? 0;
        $balanceMax = $request->input('balanceMax') ?? self::DEFULT_MAX_BALANCE;

        $data = array_filter($data, function($item) use ($balanceMax, $balanceMin) {
            return $item['amount'] >= $balanceMin && $item['amount'] <= $balanceMax;
        });

        return array_values($data);
    }
}
