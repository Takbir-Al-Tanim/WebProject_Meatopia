<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// XAMPP Default Configuration
$host = "127.0.0.1"; // Use IP instead of 'localhost'
$username = "root";
$password = ""; // XAMPP default is empty
$database = "Meatopia";
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . 
        " | Error No: " . $conn->connect_errno);
}

echo "<!-- Debug: Connected successfully to XAMPP MySQL -->";
?>