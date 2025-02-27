<?php
include('../../admin/config.php');

// Approve all pending users
$sql = "UPDATE dhumkhetu SET is_approved = 1 WHERE is_approved = 0";
if ($conn->query($sql) === TRUE) {
    echo "All pending users have been approved.";
    // Redirect to the admin dashboard after approving
    header("Location:admin.php"); // Replace with your actual admin dashboard URL
    exit;
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
