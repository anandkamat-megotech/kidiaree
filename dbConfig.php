<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "u619540767_root_kids";
$dbPassword = "L1m1tl3ss1!";
$dbName     = "u619540767_kids";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}