<?php
// config.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'accounting_system'; // ✅ make sure this matches your phpMyAdmin DB name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Tuition per course
$courses = [
    'BSIT' => ['tuition' => 20000],
    'BSCS' => ['tuition' => 25000],
    'BSAT' => ['tuition' => 22000],
];

// Escape HTML helper
if (!function_exists('h')) {
    function h($str) {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}
