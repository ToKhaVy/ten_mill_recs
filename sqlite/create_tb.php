<?php
$db = new SQLite3('ten_mill_records.db');

$sql = ' CREATE TABLE user_test (
         ID         INT PRIMARY KEY,
         FirstName  TEXT,
         LastName   TEXT,
         Address    TEXT,
         Birthday   TEXT
        ) ';

if ($db->exec($sql)) {
    echo 'Create a table successfully';
} else echo 'Failed';


$db->close();
