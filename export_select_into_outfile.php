<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$search = isset($_POST['search-address']) ? $_POST['search-address'] : '';
$sort = isset($_POST['sort-order']) ? $_POST['sort-order'] : 'ASC';

$csv_file = 'data_download.csv';

$server_path = '/htdocs/ten_mill_recs/data/' . $csv_file;

$sql = " SELECT ID,FirstName,LastName,Address,Birthday 
            INTO OUTFILE '$server_path'
            FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\\n' 
         FROM user ";

if (!empty($search)) {
    $sql .= " WHERE Address LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' ";
}

$sql .= " ORDER BY STR_TO_DATE(Birthday, '%b-%d-%Y') $sort";

$result = mysqli_query($conn, $sql);

if ($result) {

    // Set response headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . basename($server_path) . '"');

    $file = fopen($server_path, 'rb');

    if ($file) {
        $chunk_size = 1024 * 1024 * 8;

        while (!feof($file)) {
            echo fread($file, $chunk_size);
            ob_flush();
            flush();
        }

        fclose($file);
    } else {
        echo 'Error opening file.';
    }

    unlink($server_path);
} else {
    echo 'Error exporting file: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Data exported: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////