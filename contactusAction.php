<?php
if (!(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['number']) && isset($_POST['email']) && isset($_POST['message']))) {
    header('location: index.php#contact');
    exit;
}

include('./config/db_connect.php');

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$mobile = $_POST['number'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO contact_us (firstname, lastname, mobile, email, message) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sssss', $fname, $lname, $mobile, $email, $message);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
    alert('Sent Message Successfully');
    window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
    alert('Not able to sent Message Currently');
    window.location.href = 'index.php';
    </script>";
}
