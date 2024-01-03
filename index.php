<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);
//Truncate table
$sql_truncate = " TRUNCATE TABLE `user`";
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

$batch_size = 1000;


for ($i = 0; $i < $records_count; $i += $batch_size) {
    $value = array();

    for ($j = 0; $j < $batch_size; $j++) {

        $row = fgetcsv($csv_read);
        if ($row == false) {
            break;
        } else {
            $id = mysqli_real_escape_string($conn, $row[0]);
            $first_name = mysqli_real_escape_string($conn, $row[1]);
            $last_name  = mysqli_real_escape_string($conn, $row[2]);
            $address = mysqli_real_escape_string($conn, $row[3]);
            $birthday = mysqli_real_escape_string($conn, $row[4]);
            //Add value to the batch
            $value[] = "('$id', '$first_name', '$last_name', '$address', '$birthday')";
        }
    }
    if ($row == false) {
        break;
    }
    //echo 'j = ' . $j . '<br>';
    //echo 'id = ' . $id . '<br>';
    //echo $value[1] . '<br>';
    //SELECT COUNT(ID) FROM `user`
    $sql = " INSERT INTO `user`(`ID`, `FirstName`, `LastName`, `Address`,`Birthday`) 
            VALUES " . implode(",", $value);
    //echo 'SQL query: ' . $sql . '<br>';
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo 'Failed: ' . mysqli_error($conn) .  '<br>';
        break;
    }

    //echo 'i = ' . $i . '<br>';
}


$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////