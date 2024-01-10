<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$table_name = 'user';
//Truncate table
$sql_truncate = " TRUNCATE TABLE $table_name";
$result_truncate = mysqli_query($conn, $sql_truncate);

if ($result_truncate) {
    echo 'Truncate table successfully<br>';
} else {
    echo 'Failed: ' . mysqli_error($conn);
}

$csv_file_path = 'data/user.csv';

// Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'Open file succcessfully<br>';

// Skip the header
$header = fgetcsv($csv_read);

$records_count = 10000000;
echo $records_count . '<br>';

$batch_size = 100000;

mysqli_begin_transaction($conn);

$value = array();
$i = 0;

while ($row = fgetcsv($csv_read)) {
    $i++;
    $id = mysqli_real_escape_string($conn, $row[0]);
    $first_name = mysqli_real_escape_string($conn, $row[1]);
    $last_name  = mysqli_real_escape_string($conn, $row[2]);
    $address = mysqli_real_escape_string($conn, $row[3]);
    $birthday = mysqli_real_escape_string($conn, $row[4]);

    //echo $id . '<br>';
    //Add value to the batch
    $value[] = "('$id', '$first_name', '$last_name', '$address', '$birthday')";

    if (count($value) == $batch_size || $i == $records_count) {
        //echo count($value) . '<br>';
        $insert_query = " INSERT INTO $table_name (ID, FirstName, LastName, Address,Birthday) 
                          VALUES " . implode(",", $value);
        //echo 'SQL query: ' . $insert_query . '<br>';
        $result = mysqli_query($conn, $insert_query);

        $value = [];

        if (!$result) {
            mysqli_rollback($conn);
            echo 'Insert Failed: <br>';
            break;
        }
    }
}


mysqli_commit($conn);

// Close the database connection
mysqli_close($conn);

fclose($csv_file);
echo 'Readed<br>';

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////