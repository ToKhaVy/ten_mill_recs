<?php

// Connect db
$db = new SQLite3('ten_mill_records.db');

// Define a custom SQLite function to convert date format
$db->createFunction('date_format', function ($date) {
    if ($date) {
        $date_parts = date_parse_from_format('M-d-Y', $date);
        return sprintf('%04d-%02d-%02d', $date_parts['year'], $date_parts['month'], $date_parts['day']);
    }
    return null;
});


//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$search = isset($_POST['search-address']) ? $_POST['search-address'] : '';
$sort = isset($_POST['sort-order']) ? $_POST['sort-order'] : 'ASC';

$csv_file = 'sqlite_data_download.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $csv_file . '"');

$output = fopen('php://output', 'w');

fputcsv($output, ['ID', 'FirstName', 'LastName', 'Address', 'Birthday']);

// Start the transaction
$db->exec('BEGIN');

// Fetch and write data to the CSV file in batches
$start = 0;
$batch_size = 550000;

while (true) {
    // Adjust the LIMIT clause based on the batch size
    $batch_query = " SELECT ID,FirstName,LastName,Address,Birthday FROM user ";

    if (!empty($search)) {
        $batch_query .= " WHERE Address LIKE '%" . SQLite3::escapeString($search) . "%' ";
    }

    $batch_query .= " ORDER BY date_format(Birthday) $sort LIMIT $batch_size OFFSET $start ";

    // Perform the query
    $result = $db->query($batch_query);

    // Fetch the first row
    $first_row = $result->fetchArray(SQLITE3_ASSOC);

    // Break the loop if no more rows
    if ($first_row === false) {
        break;
    }

    // Fetch and write data to the CSV file
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        fputcsv($output, $row);
    }


    // Increment the start point for the next batch
    $start += $batch_size;
}

// Commit the transaction
$db->exec('COMMIT');

fclose($output);

$db->close();

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Data exported: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////
