<?php
include '../../../admin/config.php';

// Check if the table exists
$table_check_sql = "SHOW TABLES LIKE 'exam_answers'";
$table_check_result = $conn->query($table_check_sql);

if ($table_check_result && $table_check_result->num_rows > 0) {
    // SQL query to delete all data from exam_answer table
    $sql = "DELETE FROM exam_answers";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // If deletion is successful, show the alert and redirect
        echo "<script>
                alert('Successfully deleted User Answer data. Are you going to admin page?');
                window.location.href = '../admin.php';  // Redirect to admin.php
              </script>";
    } else {
        echo "Error deleting data: " . $conn->error;
    }
} else {
    echo "Table 'exam_answers' does not exist in the database.";
}

// Close connection
$conn->close();
?>
