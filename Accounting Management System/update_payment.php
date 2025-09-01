<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = intval($_POST['id']);
    $school_year = $_POST['school_year'];
    $semester    = $_POST['semester'];
    $payment_type= $_POST['payment_type'];
    $pay_amount  = floatval($_POST['pay_amount']);

    // Fetch current record
    $sql = "SELECT total_paid, remaining FROM student_payments WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_total     = $row['total_paid'] + $pay_amount;
        $new_remaining = $row['remaining'] - $pay_amount;

        if ($new_remaining < 0) {
            echo "<script>alert('❌ Payment exceeds remaining balance!');window.location.href='studentrecords.php';</script>";
            exit;
        }

        // Update the existing record
        $update = "UPDATE student_payments 
                   SET total_paid = '$new_total', 
                       remaining = '$new_remaining', 
                       school_year = '$school_year'
                   WHERE id = $id";
        if ($conn->query($update)) {
            echo "<script>alert('✅ Payment updated successfully!');window.location.href='studentrecords.php';</script>";
        } else {
            echo "<script>alert('❌ Database error: " . $conn->error . "');window.location.href='studentrecords.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Student record not found!');window.location.href='studentrecords.php';</script>";
    }
}
?>
