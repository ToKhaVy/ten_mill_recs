<?php
require 'vendor/autoload.php';
require 'db_connect.php';


if (isset($_POST['submit'])) {
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

    $start_time = microtime(true);

    //Truncate table
    $sql_truncate = " TRUNCATE TABLE `user_test`";
    $result_truncate = mysqli_query($conn, $sql_truncate);

    if ($result_truncate) {
        echo 'Truncate table successfully<br>';
    } else {
        echo 'Failed: ' . mysqli_error($conn);
    }

    //Load data
    $sql_load_data = " LOAD DATA
            INFILE '$target_file'
            INTO TABLE user_test
            FIELDS
                TERMINATED BY ','
                OPTIONALLY ENCLOSED BY '\"'
            LINES
                TERMINATED BY '\\n'
            IGNORE 1 LINES ";
    
    $result_load_data = mysqli_query($conn, $sql_load_data);
    if (!$result_load_data){
        echo 'Load data successfully<br>';
    } else {
        echo 'Failed: ' . mysqli_error($conn);
    }
}

mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Load data completed in " . number_format($execution_time, 4) . " seconds.";


