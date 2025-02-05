<?php

use Illuminate\Support\Facades\Route;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Helpers\ArrayHelpers;
<!-- ARRAy CHUNKING (27 seconds exection time) -->
Route::get('/', function () {
    // ini_set('max_execution_time', 600);
    // ini_set('memory_limit', '1024M');
    
    $smallPath = storage_path('app/data.csv');

    $generateRow = function($row) {
        return [
            'name' => $row[0],
            'email' => $row[1],
            'mobile' => $row[2],
        ];
    };

    $insertedCount = 0;


        foreach (ArrayHelpers::chunkFile($smallPath, $generateRow, 1000) as $chunk) {
            Company::insert($chunk);
            $insertedCount += count($chunk);
        }



        return "CSV imported successfully! Inserted " . $insertedCount . " records";
   

    echo '<p>Finished database insert</p>';
});
