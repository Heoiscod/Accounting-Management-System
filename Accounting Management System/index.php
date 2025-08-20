<?php
session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Registration</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <div class="card">
    <div class="logo" style="text-align:center;">
      <img src="image/logo.png" alt="School Logo">
    </div>

    <header><h1>Student Registration</h1></header>

    <form method="post" action="payment.php" class="grid">
        <input type="hidden" name="action" value="register">

        <div class="col-6">
          <label>Student ID</label>
          <input type="text" name="studentid" required>
        </div>

        <div class="col-6">
          <label>First Name</label>
          <input type="text" name="first_name" required>
        </div>

        <div class="col-6">
          <label>Middle Initial</label>
          <input type="text" name="middle_initial" maxlength="1" placeholder="M" required>
        </div>

        <div class="col-6">
          <label>Last Name</label>
          <input type="text" name="last_name" required>
        </div>

        <div class="col-6">
          <label>Suffix</label>
          <select name="suffix">
            <option value="">-- None --</option>
            <option value="Jr.">Jr.</option>
            <option value="Sr.">Sr.</option>
            <option value="II">II</option>
            <option value="III">III</option>
            <option value="IV">IV</option>
            <option value="N/A">N/A</option>
          </select>
        </div>

        <div class="col-6">
          <label>Age</label>
          <input type="number" name="age" required>
        </div>

        <div class="col-6">
          <label>Course</label>
          <select name="course" required>
            <option value="">-- Select Course --</option>
            <option value="BSIT">BSIT</option>
            <option value="BSCS">BSCS</option>
            <option value="BSAT">BSAT</option>
          </select>
        </div>

        <div class="col-6">
          <label>Year Level</label>
          <select name="year_level" required>
            <option value="">-- Select Year Level --</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
          </select>
        </div>

        <div class="col-6">
          <label>School Year</label>
          <input type="text" name="school_year" placeholder="2025-2026" required>
        </div>

        <div class="col-6">
          <label>Semester</label>
          <select name="semester" required>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
            <option value="3rd Semester">3rd Semester</option>
          </select>
        </div>

        <div class="col-12 row">
          <button class="btn" type="submit">Proceed to Payment</button>
        </div>
    </form>
  </div>
</div>
</body>
</html>
