<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);
//Truncate table
$sql_truncate = " TRUNCATE TABLE `user_test`";
$result_truncate = mysqli_query($conn, $sql_truncate);

if ($result_truncate) {
    echo 'Truncate table successfully<br>';
} else {
    echo 'Failed: ' . mysqli_error($conn);
}

// Path to your CSV file
$csv_file_path = 'data/user.csv';
//$csv_file_path = 'data/user_test.csv';
//$csv_file_path = 'data/user_100k.csv';
//$csv_file_path = 'data/user_100.csv';

// Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'Open file succcessfully<br>';

// Skip the header line
fgetcsv($csv_read);

// SQL statement with placeholders
$sql = " INSERT INTO `user_test` (`ID`, `FirstName`, `LastName`, `Address`,`Birthday`) VALUES (?, ?, ?, ?, ?) ";

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die('Error in preparing statement: ' . mysqli_error($conn));
} else echo 'Prepareing successfully<br>';

// Bind variables to the prepared statement
mysqli_stmt_bind_param($stmt, 'issss', $id, $first_name, $last_name, $address, $birthday);

// Loop through the CSV file and insert records
while (($row = fgetcsv($csv_read)) !== false) {

    $id = mysqli_real_escape_string($conn, $row[0]);
    $first_name = mysqli_real_escape_string($conn, $row[1]);
    $last_name  = mysqli_real_escape_string($conn, $row[2]);
    $address = mysqli_real_escape_string($conn, $row[3]);
    $birthday = mysqli_real_escape_string($conn, $row[4]);

    // Execute the prepared statement
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error executing statement: " . mysqli_stmt_error($stmt) . "<br>";
        break;
    }
}

// Close the prepared statement and CSV file handle
mysqli_stmt_close($stmt);
fclose($csv_read);

// Close the database connection
mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////