<?php
require 'vendor/autoload.php';
require 'db_connect.php';


$start_time = microtime(true);

$csv_file_path = '/htdocs/ten_mill_recs/data/select_into_outfile.csv';



$sql = " SELECT ID,FirstName,LastName,Address,Birthday
            INTO OUTFILE '$csv_file_path'
            FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n'
         FROM user ";

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
