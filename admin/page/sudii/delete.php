<?php
include '../../config.php';

// Check if the 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare the DELETE SQL statement
    $sql = "DELETE FROM arafat WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    // Execute the query
    if ($stmt->execute()) {
        // Successfully deleted, redirect back to the main page
        header("Location: sudi.php"); // Replace 'your_main_page.php' with the actual file name
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    // Close the statement and connection
    $stmt->close();
}
$conn->close();
?>
