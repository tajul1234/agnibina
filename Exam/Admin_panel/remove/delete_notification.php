<?php
include '../../../admin/config.php';

// Start a transaction
$conn->begin_transaction();

try {
    // SQL query to delete all data from exam_answers table
    $sql_answers = "DELETE FROM notifications";
    
    // SQL query to delete all data from exam_question table
    $sql_questions = "DELETE FROM notifications";
    
    // Execute the queries
    if ($conn->query($sql_answers) === TRUE && $conn->query($sql_questions) === TRUE) {
        // Commit the transaction
        $conn->commit();
        
        // Show success message with redirection to admin page
        echo "<script>
                alert('Successfully deleted all data from exam_answers and exam_question tables. Redirecting to admin page...');
                window.location.href = '../admin.php';  // Redirect to admin.php
              </script>";
    } else {
        // If there is an error, roll back the transaction
        $conn->rollback();
        echo "Error deleting data: " . $conn->error;
    }
} catch (Exception $e) {
    // Rollback the transaction in case of error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn->close();
?>
