<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class JsonDataService
{
    protected $fileName;

    public function __construct($fileName = 'data.json')
    {
        $this->fileName = $fileName;
    }

    public function getData()
    {
        $path = storage_path() . "\app\public\data.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        return json_decode(file_get_contents($path), true);
    }
}
