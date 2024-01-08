<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$search = isset($_POST['search-address']) ? $_POST['search-address'] : '';
$sort = isset($_POST['sort-order']) ? $_POST['sort-order'] : 'ASC';

$csv_file = 'data_download.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $csv_file . '"');

$output = fopen('php://output', 'w');

fputcsv($output, ['ID', 'FirstName', 'LastName', 'Address', 'Birthday']);


// Fetch and write data to the CSV file in batches
$start = 0;
$batch_size = 400000;

while (true) {
    // Adjust the LIMIT clause based on the batch size
    $batch_query = " SELECT ID,FirstName,LastName,Address,Birthday FROM user ";

    if (!empty($search)) {
        $batch_query .= " WHERE Address LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' ";
    }

    $batch_query .= " ORDER BY STR_TO_DATE(Birthday, '%b-%d-%Y') $sort LIMIT $batch_size OFFSET $start ";

    // Perform the query
    $result = mysqli_query($conn, $batch_query);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    // Check if there are no more records
    if (mysqli_num_rows($result) == 0) {
        //echo 1;
        break;
    }

    // Fetch and write data to the CSV file
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }


    // Increment the start point for the next batch
    $start += $batch_size;
}

fclose($output);

mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Data exported: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////