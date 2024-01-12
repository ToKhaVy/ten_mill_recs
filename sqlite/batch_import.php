<?php
//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);
// Open the SQLite database
$db = new SQLite3('ten_mill_records.db');

// Specify the table you want to truncate
$table_name = "user";

// Truncate the table by executing a DELETE statement without a WHERE clause
$delete_query = " DELETE FROM  $table_name ";
if ($db->exec($delete_query)) {
    echo "Delete from table successfully<br>";
} else echo "Delete table fail<br>";

$db->exec('VACUUM');

$csv_file_path = '../data/user.csv';

// Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.<br>');
} else echo 'Open file succcessfully<br>';

// Skip the header
$header = fgetcsv($csv_read);

$batch_size = 50000;
//echo 'batch size' . $batch_size . '<br>';

$value = array();

$db->exec('BEGIN');

while ($row = fgetcsv($csv_read)) {

    $id = SQLite3::escapeString($row[0]);
    $first_name = SQLite3::escapeString($row[1]);
    $last_name  = SQLite3::escapeString($row[2]);
    $address = SQLite3::escapeString($row[3]);
    $birthday = SQLite3::escapeString($row[4]);

    //echo $id . '<br>';
    //Add value to the batch
    $value[] = "('$id', '$first_name', '$last_name', '$address', '$birthday')";

    if (count($value) == $batch_size) {
        //echo count($value) . '<br>';
        $insert_query = " INSERT INTO   $table_name  (ID, FirstName, LastName, Address,Birthday) 
                          VALUES " . implode(',', $value);
        //echo 'SQL query: ' . $insert_query . '<br>';
        $result = $db->exec($insert_query);

        $value = [];
    }
}

if (!empty($value)) {
    //echo count($value) . '<br>';
    $insert_query = " INSERT INTO   $table_name  (ID, FirstName, LastName, Address,Birthday) 
                      VALUES " . implode(',', $value);
    //echo 'SQL query: ' . $insert_query . '<br>';
    $result = $db->exec($insert_query);

    $value = [];
}

//Commit transaction
$db->exec('COMMIT');

// Close the SQLite database
$db->close();

fclose($csv_read);

//echo 'Readed<br>';

$end_time = microtime(true);
$execution_time = $end_time - $start_time;
echo "Read file: " . number_format($execution_time, 4) . " seconds";
//////////////////////////////////////////////////////////////////////////