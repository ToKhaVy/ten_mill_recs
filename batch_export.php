<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

// Table name in MySQL
$table_name = 'user';

// Path to the CSV file
$csv_path = 'data/batch_export_data.csv';

// Open the CSV file for writing
$csv_file = fopen($csv_path, 'w');

if (!$csv_file) {
    die("Error opening CSV file: $csv_path");
}

// Write the header line to the CSV file
$header = array('ID', 'FirstName', 'LastName', 'Address', 'Birthday');
fputcsv($csv_file, $header);

$records_count = 10000000;
echo $records_count . '<br>';

// Set the batch size
$batch_size = 570000;
echo $batch_size . '<br>';

// Fetch and write data to the CSV file in batches
$start = 0;
while ($start < $records_count) {
    // Adjust the LIMIT clause based on the batch size
    $batch_query = " SELECT ID,FirstName,LastName,Address,Birthday FROM `user` LIMIT $start, $batch_size ";

    // Perform the query
    $result = mysqli_query($conn, $batch_query);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    // Check if there are no more records
    if (mysqli_num_rows($result) == 0) {
        //echo 1;
        break;
    }

    // Fetch and write data to the CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($csv_file, $row);
    }

    // Increment the start point for the next batch
    $start += $batch_size;
}

// Close the CSV file
fclose($csv_file);

// Close the database connection
mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Data exported: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////