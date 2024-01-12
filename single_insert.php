
<?php
require 'vendor/autoload.php';
require 'db_connect.php';

use Faker\Factory;

$faker = Factory::create();

// echo $faker->firstName . '<br>';
// echo $faker->lastName . '<br>';
// echo $faker->address . '<br>';
// echo $faker->date('M-d-Y') . '<br>';


//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$records_count = 1000000;

//Truncate table
$sql_truncate = " TRUNCATE TABLE `user_test`";
$result_truncate = mysqli_query($conn, $sql_truncate);

if ($result_truncate) {
    echo 'Truncate table successfully<br>';
} else {
    echo 'Failed: ' . mysqli_error($conn);
}

$csv_file_path = 'data/user_100.csv';


// Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'Open file succcessfully<br>';

// Skip the header
$header = fgetcsv($csv_read);

// Read each line from the CSV file and display the data
while (($row = fgetcsv($csv_read)) !== false) {

    $id = mysqli_real_escape_string($conn, $row[0]);
    $first_name = mysqli_real_escape_string($conn, $row[1]);
    $last_name  = mysqli_real_escape_string($conn, $row[2]);
    $address = mysqli_real_escape_string($conn, $row[3]);
    $birthday = mysqli_real_escape_string($conn, $row[4]);

    $sql = " INSERT INTO `user_test`(`ID`, `FirstName`, `LastName`, `Address`,`Birthday`) 
    VALUES ('$id','$first_name','$last_name','$address','$birthday') ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo 'Failed: ' . mysqli_error($conn) . $id . '<br>';
    }
}

echo $id . '<br>';

fclose($csv_file);
echo 'Readed<br>';

// Close the database connection
mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////
