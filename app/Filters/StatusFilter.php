<?php

namespace App\Filters;

use App\Http\Interfaces\FilterInterface;

class StatusFilter implements FilterInterface {
    public function filter($data, $request) {
        $statusCode = $request->input('statusCode');

        if ($statusCode) {
            $data = array_filter($data, function($item) use ($statusCode) {
                return $item['status'] == $statusCode;
            });
        }

        return array_values($data);
    }
}
