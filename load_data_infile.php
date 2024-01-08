<?php
require 'vendor/autoload.php';
require 'db_connect.php';


$start_time = microtime(true);

//Truncate table
$sql_truncate = " TRUNCATE TABLE `user`";
$result_truncate = mysqli_query($conn, $sql_truncate);

if ($result_truncate) {
    echo 'Truncate table successfully<br>';
} else {
    echo 'Failed: ' . mysqli_error($conn);
}

// Read file
$csv_file_path = '/htdocs/ten_mill_recs/data/user.csv';

$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'Open file succcessfully<br>';


$sql = " LOAD DATA
            INFILE '$csv_file_path'
            INTO TABLE user
            FIELDS
                TERMINATED BY ','
                OPTIONALLY ENCLOSED BY '\"'
            
            LINES
                TERMINATED BY '\\n'
            
            IGNORE 1 LINES ";

echo $sql . '<br>';

$result = mysqli_query($conn, $sql);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;

if (!$result) {
    echo "Error: " . $conn->error;
} else {
    echo "Data loaded successfully.\n";
    echo "Load data completed in " . number_format($execution_time, 4) . " seconds.";
}

mysqli_close($conn);
