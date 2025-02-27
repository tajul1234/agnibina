<?php
include '../../admin/config.php';
session_start();

// Get user ID from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    echo "User not logged in!";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];

    // Validate the file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file!";
        exit;
    }

    // Check file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        echo "Only JPG, PNG, and GIF images are allowed!";
        exit;
    }

    // Check file size (max 2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        echo "File is too large. Max size is 2MB!";
        exit;
    }

    // Generate a new unique filename
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid('profile_') . '.' . $file_ext;

    // Define the upload directory
    $upload_dir = '../login_system/';

    // Move the uploaded file to the upload directory
    if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename)) {
        // Update the picture in the database
        $sql = "UPDATE dhumkhetu SET picture = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_filename, $user_id);
        if ($stmt->execute()) {
            echo "Profile picture updated successfully!";
            // Redirect back to the profile page
            header("Location: user_account.php?id=" . $user_id);
            exit;
        } else {
            echo "Error updating the profile picture!";
        }
    } else {
        echo "Error moving the uploaded file!";
    }
}
?>
