<?php
session_start();
include 'config.php';

// Fetch all student records
$sql = "SELECT id, first_name, last_name, school_year, tuition, total_paid, remaining 
        FROM student_payments 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Records</title>
  <link rel="stylesheet" href="style.css">
  <style>
   table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  font-size: 15px;
}

th, td {
  padding: 12px 10px;
  border: 1px solid #ddd;
  text-align: center;
}

th {
  background: #007bff;
  color: #fff;
  font-weight: 600;
}

tr:nth-child(even) {
  background: #f9f9f9;
}

tr:hover {
  background: #f1f1f1;
}

.actions {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.actions a {
  padding: 6px 14px;
  font-size: 14px;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.3s ease;
}

.update {
  background: #28a745;
  color: white;
}

.update:hover {
  background: #218838;
}

.print {
  background: #f39c12;
  color: white;
}

.print:hover {
  background: #d68910;
}

.btn {
  display: inline-block;
  padding: 8px 16px;
  background: #007bff;
  color: #fff;
  border-radius: 5px;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.3s ease;
}

.btn:hover {
  background: #0056b3;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  max-width: 95%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.modal-content h2 {
  margin-bottom: 15px;
  font-size: 18px;
  text-align: center;
  color: #333;
}

.modal-content label {
  display: block;
  margin-top: 10px;
  font-size: 14px;
  color: #555;
}

.modal-content input,
.modal-content select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.modal-content button {
  margin-top: 15px;
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background: #28a745;
  color: #fff;
  font-size: 14px;
  transition: background 0.3s ease;
}

.modal-content button:hover {
  background: #218838;
}

.close {
  float: right;
  cursor: pointer;
  font-size: 20px;
  color: #e74c3c;
  font-weight: bold;
}

.close:hover {
  color: #c0392b;
}

  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <header><h1>Student Records</h1></header>

    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>School Year</th>
          <th>Tuition</th>
          <th>Total Paid</th>
          <th>Remaining Balance</th>
          <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?=htmlspecialchars($row['first_name'])?></td>
            <td><?=htmlspecialchars($row['last_name'])?></td>
            <td><?=htmlspecialchars($row['school_year'])?></td>
            <td>₱<?=number_format($row['tuition'],2)?></td>
            <td>₱<?=number_format($row['total_paid'],2)?></td>
            <td>₱<?=number_format($row['remaining'],2)?></td>
            <td class="actions">
              <a class="update" onclick="openUpdateModal(
                  <?=$row['id']?>,
                  '<?=htmlspecialchars($row['school_year'])?>',
                  <?=$row['remaining']?>)">Update</a>
              <a class="print" onclick="openReceiptModal(<?=$row['id']?>)">Print Receipt</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No student records found.</p>
    <?php endif; ?>

    <div style="margin-top:15px;">
      <a class="btn" href="index.php">Back to Registration</a>
    </div>
  </div>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('updateModal')">&times;</span>
    <h2>Update Payment</h2>
    <form method="POST" action="update_payment.php">
      <input type="hidden" id="student_id" name="id">

      <label>School Year</label>
      <input type="text" id="school_year" name="school_year" readonly>

      <label>Payment Type</label>
      <select name="payment_type" required>
        <option value="Prelims">Prelims</option>
        <option value="Midterm">Midterm</option>
        <option value="Prefinal">Prefinal</option>
        <option value="Final">Final</option>
      </select>

      <label>Remaining Balance</label>
      <input type="text" id="remaining_balance" readonly>

      <label>Pay Amount</label>
      <input type="number" name="pay_amount" min="1" step="0.01" required>

      <button type="submit" style="background:#28a745;color:white;">Update</button>
    </form>
  </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('receiptModal')">&times;</span>
    <h2>Receipt</h2>
    <iframe id="receiptFrame" src="" width="100%" height="400px" style="border:none;"></iframe>
  </div>
</div>

<script>
function openUpdateModal(id, school_year, remaining) {
  document.getElementById('student_id').value = id;
  document.getElementById('school_year').value = school_year;
  document.getElementById('remaining_balance').value = "₱" + parseFloat(remaining).toFixed(2);
  document.getElementById('updateModal').style.display = 'flex';
}
function openReceiptModal(id) {
  document.getElementById('receiptFrame').src = "receipt.php?id=" + id;
  document.getElementById('receiptModal').style.display = 'flex';
}
function closeModal(modalId) {
  document.getElementById(modalId).style.display = 'none';
}
</script>
</body>
</html>
