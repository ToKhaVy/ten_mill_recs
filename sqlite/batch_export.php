<?php
// Open the SQLite database
$db = new SQLite3('ten_mill_records.db');

// Specify the table you want to export
$table_name = 'user';

// Set response headers for file download (CSV in this example)
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="exported_data.csv"');

// Open a file handle for writing CSV data
$output = fopen('php://output', 'w');

// Write the header row
$query = "PRAGMA table_info($table_name)";
$result = $db->query($query);
$columns = [];
while ($column = $result->fetchArray(SQLITE3_ASSOC)) {
    $columns[] = $column['name'];
}
fputcsv($output, $columns);

// Fetch and write the data rows in batches
$batchSize = 1000; // Adjust based on performance
$query = " SELECT ID,FirstName,LastName,Address,Birthday FROM $table_name ";
$result = $db->query($query);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    fputcsv($output, $row);

    // Check if a batch is complete and reset the file handle
    if (ftell($output) >= $batchSize) {
        fclose($output);
        $output = fopen('php://output', 'w');
        fputcsv($output, $columns); // Write the header row again
    }
}

// Close the file handle
fclose($output);

// Close the SQLite database
$db->close();
