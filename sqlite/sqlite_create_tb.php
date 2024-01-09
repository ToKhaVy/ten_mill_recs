<?php
$db = new SQLite3('sqlite.db');

$sql = ' CREATE TABLE IF NOT EXISTS user (
         ID INTEGER PRIMARY KEY AUTOINCREMENT,
         FirstName TEXT,
         LastName TEXT,
         Address TEXT,
         Birthday TEXT
) ';

if ($db->exec($sql)) {
    echo 'Create a table successfully';
} else echo 1;

// $sql_insert = ' INSERT INTO user (ID,FirstName,LastName,Address,Birthday) 
//                 VALUES (null,"Kha Vy","To","36 Nguyen An Ninh","5-6-97" ) ';

// if ($db->exec($sql_insert)) {
//     echo 'Insert successfully';
// } else echo 2;

$db->close();
