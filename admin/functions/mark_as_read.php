<?php
// Database connection
include('./../../config/db_connect.php');

// Check if the request is a POST request and contains the 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $message_id = $_POST['id'];

    // Update the message status to 'read'
    $sql = "UPDATE contact_us SET seen = '1' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $message_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "invalid request";
}
