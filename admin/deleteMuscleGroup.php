<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

include('./../config/db_connect.php');

$sql = 'SELECT * FROM muscle_group WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $file_name = $row['photo'];
} else {
    echo "No record Found";
    echo '<br><a href="index.php">Go to Dashboard</a>';
    exit();
}

mysqli_stmt_close($stmt);

$sql = 'DELETE FROM muscle_group WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        if (file_exists('../uploads/' . $file_name)) {
            unlink('../uploads/' . $file_name);
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer_url = $_SERVER['HTTP_REFERER'];
            header("Location: $referer_url");
            exit;
        } else {
            header("Location: viewMuscleGroups.php");
            exit;
        }
    } else {
        echo "No record Found with id: " . $_GET['id'];
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
