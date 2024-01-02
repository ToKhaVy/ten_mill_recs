<?php
require 'vendor/autoload.php';
require 'db_connect.php';

use Faker\Factory;

$faker = Factory::create();

// echo $faker->firstName . '<br>';
// echo $faker->lastName . '<br>';
// echo $faker->address . '<br>';
// echo $faker->date('M-d-Y') . '<br>';



$start_time = microtime(true);
//////////////////////////////////////////////////////////////////////////
$records_count = 100000;

$csv_file_path = 'data/user_test.csv';
//$csv_file_path = 'data/user.csv';
$csv_header = ['ID', 'FirstName', 'LastName', 'Address', 'Birthday'];

$csv_file = fopen($csv_file_path, 'w');

if ($csv_file === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for writing.');
} else echo 'open file succcessfully<br>';

fputcsv($csv_file, $csv_header);

$id = 0;

for ($i = 0; $i < $records_count; $i++) {

    $records_data = [
        $id++,
        $faker->firstName,
        $faker->lastName,
        $faker->address,
        $faker->date('M-d-Y')
    ];

    fputcsv($csv_file, $records_data);
}


fclose($csv_file);
echo 'writed<br>';

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Script execution time: " . number_format($execution_time, 4) . " seconds";
