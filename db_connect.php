<?php
$servername = 'localhost';
$username = 'root';
$password = 'cms-8341';
$db_name = 'ten_mill_rec_db';

// connection
$conn = new mysqli($servername, $username, $password, $db_name);

// check
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
// else echo 'Connected DB successfully<br>';

$conn->set_charset('utf8mb4');
