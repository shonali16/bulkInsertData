<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    $startTime = microtime(true);
 

    try {
         // Enable LOCAL INFILE for this connection
         DB::connection()->getPdo()->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
         $filePath = storage_path('app/data.csv');
        $escapedPath = DB::getPdo()->quote($filePath);
        
        DB::statement("
            LOAD DATA LOCAL INFILE {$escapedPath}
            INTO TABLE companies
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\\n'
            IGNORE 1 LINES
            (name, email, mobile)
        ");

        // Get affected rows count
        $insertedCount = DB::select("SELECT ROW_COUNT() as count")[0]->count;

    } catch (\Exception $e) {
        Log::error('CSV Import Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }

    $executionTime = round(microtime(true) - $startTime, 2);
    $memoryUsage = round(memory_get_peak_usage(true) / 1024 / 1024, 2);

    // Log results
    Log::info("CSV Import Completed", [
        'method' => 'LOAD_DATA_INFILE',
        'execution_time' => $executionTime,
        'records_inserted' => $insertedCount,
        'memory_usage' => $memoryUsage
    ]);

    return response()->json([
        'message' => 'CSV imported successfully!',
        'method' => 'MySQL LOAD DATA INFILE',
        'records_inserted' => $insertedCount,
        'execution_time' => "$executionTime seconds",
        'memory_usage' => "$memoryUsage MB"
    ]);
});
// 2nd way is in Readme(Array CHunking)
