<?php
require 'vendor/autoload.php';
require 'db_connect.php';

//////////////////////////////////////////////////////////////////////////
$start_time = microtime(true);

$search = isset($_POST['search-field'])