<?php
require 'vendor/autoload.php';
require 'db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "data/";
    $target_file = $target_dir . basename($_FILES['csv-file']['name']);

    echo $_FILES['csv-file']['tmp_name'] . '<br>';
    echo $target_dir . '<br>';
    echo $target_file . '<br>';

    // Move uploaded file to the specified directory
    if (move_uploaded_file($_FILES["csv-file"]["tmp_name"], $target_file)) {
        echo "File uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}


// $start_time = microtime(true);

// //Truncate table
// $sql_truncate = " TRUNCATE TABLE `user_test`";
// $result_truncate = mysqli_query($conn, $sql_truncate);

// if ($result_truncate) {
//     echo 'Truncate table successfully<br>';
// } else {
//     echo 'Failed: ' . mysqli_error($conn);
// }

// // Read file
// $csv_file_path = '';

// $csv_read = fopen($csv_file_path, 'r');

// if ($csv_read === false) {
//     // Handle error if the file couldn't be opened
//     die('Unable to open file for reading.');
// } else echo 'Open file succcessfully<br>';


// $sql = " LOAD DATA
//             INFILE '$csv_file_path'
//             INTO TABLE user_test
//             FIELDS
//                 TERMINATED BY ','
//                 OPTIONALLY ENCLOSED BY '\"'
            
//             LINES
//                 TERMINATED BY '\\n'
            
//             IGNORE 1 LINES ";

// echo $sql . '<br>';

// $result = mysqli_query($conn, $sql);

// $end_time = microtime(true);
// $execution_time = $end_time - $start_time;

// if (!$result) {
//     echo "Error: " . $conn->error;
// } else {
//     echo "Data loaded successfully.\n";
//     echo "Load data completed in " . number_format($execution_time, 4) . " seconds.";
// }

// mysqli_close($conn);
