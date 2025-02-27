<?php
// Include database connection
include '../../../admin/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user has already submitted
$check_submission_sql = "SELECT submitted_at FROM exam_answers WHERE user_id = ?";
$stmt = $conn->prepare($check_submission_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($submitted_at);
$stmt->fetch();

// If the user has already submitted, show a message
if ($submitted_at !== null) {
    echo "<script>alert('You have already submitted your answers.'); window.location.href = '../dashboard.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch all questions
    $question_sql = "SELECT * FROM questions";
    $question_result = $conn->query($question_sql);

    if ($question_result->num_rows > 0) {
        while ($question = $question_result->fetch_assoc()) {
            $question_id = $question['question_number'];
            $answer_key = 'answer' . $question_id;

            // Check if answer is submitted for this question
            $answer = isset($_POST[$answer_key]) ? $_POST[$answer_key] : null;

            // Insert the answer into the database
            $insert_sql = "INSERT INTO exam_answers (user_id, question_id, answer) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE answer = ?";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iiss", $user_id, $question_id, $answer, $answer);
            $stmt->execute();
        }

        // Update the submission time
        $update_submission_sql = "UPDATE exam_answers SET submitted_at = NOW() WHERE user_id = ?";
        $stmt = $conn->prepare($update_submission_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Success message
        echo "<script>
                alert('Your answers have been submitted.');
                window.location.href = 'exam_success.php';
              </script>";
    } else {
        echo "<script>alert('No questions available.');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
