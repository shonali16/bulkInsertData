<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\Company;

Route::get('/', function () {

    // ini_set('max_execution time', 600);
    $startTime = microtime(true); // Start measuring time
    
    $smallPath = storage_path('app/small_set.csv');
    $path = storage_path('app/small_set.csv');
    
    if (!file_exists($path)) {
        Log::error("CSV file not found at: {$path}");
        return "File not found!";
    }

    $file = fopen($path, 'r');
    fgetcsv($file); // Skip header

    $insertedRows = 0;
    while (($row = fgetcsv($file, null, ',')) !== false) {
        Company::create([
            'name' => $row[0],
            'email' => $row[1],
            'mobile' => $row[2],
        ]);
        $insertedRows++;
    }

    fclose($file);

    echo '<p>Finished database insert</p>';

    $executionTime = round(microtime(true) - $startTime, 2); // Calculate time
    Log::info("CSV Import Statistics", [
        'execution_time' => $executionTime . ' seconds',
        'rows_inserted' => $insertedRows,
        'file_path' => $path
    ]);

    return "CSV imported successfully! Time: {$executionTime} seconds, Rows inserted: {$insertedRows}";
});