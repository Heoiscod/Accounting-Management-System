<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['last_payment'] = $_POST;
}

if (!isset($_SESSION['last_payment'])) {
    die("No payment data available. Please submit a payment first.");
}

$payment = $_SESSION['last_payment'];

$studentid      = $payment['studentid'] ?? '';
$first_name     = $payment['first_name'] ?? '';
$middle_initial = $payment['middle_initial'] ?? '';
$last_name      = $payment['last_name'] ?? '';
$suffix         = $payment['suffix'] ?? '';
$course         = $payment['course'] ?? '';
$year_level     = $payment['year_level'] ?? '';
$school_year    = $payment['school_year'] ?? '';
$semester       = $payment['semester'] ?? '';

$prelims   = (float)($payment['prelims'] ?? 0);
$midterm   = (float)($payment['midterm'] ?? 0);
$prefinal  = (float)($payment['prefinal'] ?? 0);
$final     = (float)($payment['final'] ?? 0);

$tuition      = $courses[$course]['tuition'] ?? 0;
$total_paid   = $prelims + $midterm + $prefinal + $final;
$remaining    = $tuition - $total_paid;

// ---- INSERT INTO DATABASE ----
$stmt = $conn->prepare("INSERT INTO student_payments 
(studentid, first_name, middle_initial, last_name, suffix, course, year_level, school_year, semester, prelims, midterm, prefinal, final, tuition, total_paid, remaining)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssssssssssdddd",
    $studentid, $first_name, $middle_initial, $last_name, $suffix,
    $course, $year_level, $school_year, $semester,
    $prelims, $midterm, $prefinal, $final,
    $tuition, $total_paid, $remaining
);
$stmt->execute();
$stmt->close();
?>
<!doctype html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Receipt</title>
</head>
<body>
<div class="container">
  <div class="card">
    <div class="logo" style="text-align:center;">
      <img src="image/logo.png" alt="School Logo" style="max-height:100px;">
    </div>

    <header><h1>Official Receipt</h1></header>

    <p><strong>Student ID:</strong> <?=h($studentid)?></p>
    <p><strong>Name:</strong> <?=h($first_name . ' ' . $middle_initial . '. ' . $last_name . ' ' . $suffix)?></p>
    <p><strong>Course:</strong> <?=h($course)?></p>
    <p><strong>Year Level:</strong> <?=h($year_level)?></p>
    <p><strong>School Year:</strong> <?=h($school_year)?> | <strong>Semester:</strong> <?=h($semester)?></p>

    <h2>Payment Breakdown</h2>
    <table border="1" width="100%" cellpadding="5">
      <tr><th>Tuition Fee</th><td>₱<?=number_format($tuition,2)?></td></tr>
      <tr><th>Prelims</th><td>₱<?=number_format($prelims,2)?></td></tr>
      <tr><th>Midterm</th><td>₱<?=number_format($midterm,2)?></td></tr>
      <tr><th>Prefinal</th><td>₱<?=number_format($prefinal,2)?></td></tr>
      <tr><th>Final</th><td>₱<?=number_format($final,2)?></td></tr>
      <tr><th>Total Paid</th><td>₱<?=number_format($total_paid,2)?></td></tr>
      <tr><th>Remaining Balance</th><td>₱<?=number_format($remaining,2)?></td></tr>
    </table>

    <div class="row" style="margin-top:15px;">
      <a class="btn" href="index.php">Back to Registration</a>
      <button class="btn" onclick="window.print()">Print / Save PDF</button>
      <a class="btn danger" href="reset.php">Finish</a>
    </div>
  </div>
</div>
</body>
</html>
