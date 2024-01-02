
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

$records_count = 10000;

$csv_file_path = 'data/user_test.csv';
//$csv_file_path = 'data/user.csv';

//Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'open file succcessfully<br>';

$header = fgetcsv($csv_read);

$sql_truncate = "TRUNCATE TABLE `user`";
$result_truncate = mysqli_query($conn, $sql_truncate);

if ($result_truncate) {
    echo 'Truncate table successfully';
} else {
    echo 'Failed: ' . mysqli_error($conn);
}

//Display a table header
//echo "<table border='1'>";

// Read each line from the CSV file and display the data
while (($row = fgetcsv($csv_read)) !== false) {
    // echo "<tr>";
    // foreach ($row as $value) {
    //     echo "<td>$value</td>";
    // }
    // echo "</tr>";
    $id = mysqli_real_escape_string($conn, $row[0]);
    $first_name = mysqli_real_escape_string($conn, $row[1]);
    $last_name  = mysqli_real_escape_string($conn, $row[2]);
    $address = mysqli_real_escape_string($conn, $row[3]);
    $birthday = mysqli_real_escape_string($conn, $row[4]);
    $sql = " INSERT INTO `user`(`ID`, `FirstName`, `LastName`, `Address`,`Birthday`) 
    VALUES ('$id','$first_name','$last_name','$address','$birthday') ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo 'Failed: ' . mysqli_error($conn) . $id . '<br>';
    } else echo $id . '<br>';
}



// echo "</table>";

fclose($csv_file);
echo 'readed<br>';

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////
