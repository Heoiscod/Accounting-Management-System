<?php
// config.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'accounting_system'; // <-- replace with your DB name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$courses = [
    'BSIT' => ['tuition' => 20000],
    'BSCS' => ['tuition' => 25000],
    'BSAT' => ['tuition' => 22000],
];

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
