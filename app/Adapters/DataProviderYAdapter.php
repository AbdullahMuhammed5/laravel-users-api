<?php

namespace App\Adapters;

use App\Http\Interfaces\DataSourceInterface;

class DataProviderYAdapter implements DataSourceInterface
{
    protected array $statusCode = [];
    const CHUNK_SIZE = 1000;

    public function __construct(){
        $this->statusCode =[
            '100'  => 'authorised',
            '200'  => 'decline',
            '300'  => 'refunded'
        ];
    }

    public function getData() {
        $data = [];

        $handle = fopen(storage_path('DataProviderY.json'), 'r');

        // this solution to make sure that we will not exhaust the memory to read more than 1000 line
        while (!feof($handle)) {
            $data = array_merge($data, json_decode(stream_get_contents($handle, self::CHUNK_SIZE)));
        }

        fclose($handle);

        return array_map(function($item) {
            return [
                'parentEmail' => $item->email,
                'amount'      => $item->balance,
                'currency'    => $item->currency,
                'status'      => $this->statusCode[$item->status],
                'created_at'  => $item->created_at,
                'id'          => $item->id,
                'provider'    => 'DataProviderY',
            ];
        }, $data);
    }
}
