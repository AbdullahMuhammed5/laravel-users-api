<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\DataSourceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataProviderXAdapter implements DataSourceInterface
{
    protected array $statusCode = [];
    const CHUNK_SIZE = 1000;

    // todo - add file path as a parameter to the adaptor to not force use DataProviderX.json
    public function __construct(){
        $this->statusCode = [
            '1'  => 'authorised',
            '2'  => 'decline',
            '3'  => 'refunded'
        ];
    }

    public function getData() {
        $data = [];

        $handle = fopen(storage_path('DataProviderX.json'), 'r');

        // this solution to make sure that we will not exhaust the memory to read more than 1000 line
        while (!feof($handle)) {
            $data = array_merge($data, json_decode(stream_get_contents($handle, self::CHUNK_SIZE)));
        }

        fclose($handle);

        return array_map(function($item) {
            return [
                'parentEmail' => $item->parentEmail,
                'amount'      => $item->parentAmount,
                'currency'    => $item->Currency,
                'status'      => $this->statusCode[$item->statusCode],
                'created_at'  => $item->registerationDate,
                'id'          => $item->parentIdentification,
                'provider'    => 'DataProviderX',
            ];
        }, $data);
    }
}
