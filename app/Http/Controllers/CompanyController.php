<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // public function upload()
    // {
    //     $smallPath = storage_path('app/small_set.csv'); // Use forward slash

    //     if (!file_exists($smallPath)) {
    //         return "File not found!";
    //     }

    //     $file = fopen($smallPath, 'r');

    //     // Skip header row
    //     fgetcsv($file);

    //     while (($row = fgetcsv($file, 1000, ',')) !== false) {
    //         Company::create([
    //             'name' => $row[0],
    //             'email' => $row[1],
    //             'mobile' => $row[2],
    //         ]);
    //     }

    //     fclose($file);

    //     return "CSV imported successfully!";
    // }
    // public function index(){
    //     return view('we')
    // }
}
