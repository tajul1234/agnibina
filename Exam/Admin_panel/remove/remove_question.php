<?php
// Include the database connection file
include '../../../admin/config.php';

// Check if the delete request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // SQL query to delete all questions
    $sql = "DELETE FROM questions";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('All questions have been deleted successfully!');</script>";
        header("Location: ../admin.php");  // Redirect to admin dashboard
        exit;
    } else {
        echo "<script>alert('Error deleting questions: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete All Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Delete All Questions</h1>
        <form method="POST">
            <div class="alert alert-warning">
                <strong>Warning!</strong> This will delete all questions in the database. Are you sure you want to continue?
            </div>
            <button type="submit" class="btn btn-danger">Yes, Delete All Questions</button>
            <a href="remove.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
