<?php
require 'vendor/autoload.php';
require 'db_connect.php';

$start_time = microtime(true);

// Path to the CSV file
$csv_path = 'data/export_data.csv';

// SQL query to select data from the table
$sql = " SELECT ID,FirstName,LastName,Address,Birthday FROM `user_test` ";

// Perform the query
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Open the CSV file for writing
$csv_file = fopen($csv_path, 'w');

if (!$csv_file) {
    die("Error opening CSV file: $csv_path");
} else echo 'Open file to write successfully<br>';

// Write the header line to the CSV file
$header = array('ID', 'FirstName', 'LastName', 'Address', 'Birthday');
fputcsv($csv_file, $header);

// Fetch and write data to the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($csv_file, $row);
}

// Close the CSV file and free the result set
fclose($csv_file);

mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);


$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Data exported: " . number_format($execution_time, 4) . " seconds";
