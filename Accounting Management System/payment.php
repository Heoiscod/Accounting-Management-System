<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    // Save student info to session
    $_SESSION['student_info'] = [
        'studentid'      => $_POST['studentid'] ?? '',
        'first_name'     => $_POST['first_name'] ?? '',
        'middle_initial' => $_POST['middle_initial'] ?? '',
        'last_name'      => $_POST['last_name'] ?? '',
        'suffix'         => $_POST['suffix'] ?? '',
        'course'         => $_POST['course'] ?? '',
        'year_level'     => $_POST['year_level'] ?? '',
        'school_year'    => $_POST['school_year'] ?? '',
        'semester'       => $_POST['semester'] ?? '',
    ];
    $course = $_POST['course'] ?? '';
    $tuition = $courses[$course]['tuition'] ?? 0;
} else {
    die("No registration data submitted.");
}

$student = $_SESSION['student_info'];
$fullname = $student['first_name'] . ' ' . $student['middle_initial'] . '. ' . $student['last_name'] . ' ' . $student['suffix'];
?>
<!doctype html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Student Payment</title>
</head>
<body>
<div class="container">
  <div class="card">
    <header><h1>Payment for <?=h($fullname)?></h1></header>
    <div class="content">
      <p><strong>Course:</strong> <?=h($course)?> — ₱<?=number_format($tuition)?></p>

      <form method="post" action="receipt.php" class="grid">
        <?php foreach ($student as $key => $value): ?>
            <input type="hidden" name="<?=h($key)?>" value="<?=h($value)?>">
        <?php endforeach; ?>
        <div class="col-6"><label>Prelims</label><input type="number" name="prelims" value="0" min="0" required></div>
        <div class="col-6"><label>Midterm</label><input type="number" name="midterm" value="0" min="0" required></div>
        <div class="col-6"><label>Prefinal</label><input type="number" name="prefinal" value="0" min="0" required></div>
        <div class="col-6"><label>Final</label><input type="number" name="final" value="0" min="0" required></div>

        <div class="col-12 row">
          <button class="btn" type="submit">Generate Receipt</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
