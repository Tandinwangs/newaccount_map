<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Path to your CSV file
         $csvFile = database_path('seeds/account_details.csv');

         // Open the CSV file for reading
         if (($handle = fopen($csvFile, 'r')) !== false) {
             // Get the header row (column names)
             $headers = fgetcsv($handle);
 
             // Loop through each row and insert data into the database
             while (($data = fgetcsv($handle)) !== false) {
                 $rowData = array_combine($headers, $data);
 
                 // Insert data into the database table
                 DB::table('account_details')->insert($rowData);
             }
 
             // Close the file handle
             fclose($handle);
         }
    }
}
