<?php
require 'vendor/autoload.php';
require 'db_connect.php';

$csv_file_path = 'data/user_100.csv';
// Read file
$csv_read = fopen($csv_file_path, 'r');

if ($csv_read === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
} else echo 'Open file succcessfully<br>';

$table_name = `user`;

$sql = " LOAD DATA
            [LOW_PRIORITY | CONCURRENT] [LOCAL]
            INFILE '$csv_file_path'
            [REPLACE | IGNORE]
            INTO TABLE $table_name
            [CHARACTER SET 'utf8']
            [{FIELDS | COLUMNS}
                [TERMINATED BY ',']
                [[OPTIONALLY] ENCLOSED BY 'char']
                [ESCAPED BY 'char']
            ]
            [LINES
                [STARTING BY 'string']
                [TERMINATED BY 'string']
            ]
            [IGNORE 1 {LINES | ROWS}] ";
