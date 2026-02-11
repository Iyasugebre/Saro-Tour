<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$al = mysqli_connect("localhost", "root", "", "tours_techvegan");

if (!$al) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
