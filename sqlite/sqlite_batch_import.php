<?php

// File path for the CSV file
$csvFilePath = 'your_data.csv';

// Open the CSV file for reading
$fileHandle = fopen($csvFilePath, 'r');

if ($fileHandle === false) {
    // Handle error if the file couldn't be opened
    die('Unable to open file for reading.');
}

// Display a table header
echo "<table border='1'>";
echo "<tr><th>Name</th><th>Email</th><th>Phone</th></tr>";

// Read each line from the CSV file and display the data
while (($row = fgetcsv($fileHandle)) !== false) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}

echo "</table>";

// Close the file handle when done
fclose($fileHandle);
