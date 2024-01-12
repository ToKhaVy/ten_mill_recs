<?php

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);
// Open the SQLite database
$db = new SQLite3('ten_mill_records.db');

// Specify the table you want to export
$table_name = 'user';

// Set file path to write
$csv_file_path = '../data/sqlite_batch_export.csv';

// Open file to write
$csv_write = fopen($csv_file_path, 'w');
if (!$csv_write) {
    die('Error: Unable to open file for writing.' . PHP_EOL);
}

// Write the header row
$header = array('ID', 'FirstName', 'LastName', 'Address', 'Birthday');
fputcsv($csv_write, $header);

$batch_size = 100000;

$start = 0;

$db->exec('BEGIN');

while (true) {
    // Adjust the LIMIT clause based on the batch size
    $batch_query = " SELECT ID,FirstName,LastName,Address,Birthday FROM user LIMIT $batch_size OFFSET $start ";

    // Perform the query
    $batch_result = $db->query($batch_query);

    if (!$batch_result) {
        die("Error in SQL query: " . $db->lastErrorMsg());
    }

    // Check if the first row is false, indicating no more rows
    $first_row = $batch_result->fetchArray(SQLITE3_ASSOC);
    if ($first_row === false) {
        break;
    }

    // Process the first row
    fputcsv($csv_write, $first_row);

    // Fetch and write data to the CSV file
    while ($row = $batch_result->fetchArray(SQLITE3_ASSOC)) {
        fputcsv($csv_write, $row);
    }

    // Increment the start point for the next batch
    $start += $batch_size;
}

$db->exec('COMMIT');

// Close the file handle
fclose($csv_write);

// Close the SQLite database
$db->close();

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////