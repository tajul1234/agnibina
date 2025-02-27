<?php
// Include database connection
include '../../../admin/config.php';
session_start();

$user_id = $_SESSION['user_id'];

// Fetch questions from the database
$question_sql = "
    SELECT 
        q.question_number, 
        q.question, 
        q.option1, 
        q.option2, 
        q.option3, 
        q.option4,
        a.answer AS user_answer
    FROM 
        questions q
    LEFT JOIN 
        exam_answers a 
    ON 
        q.question_number = a.question_id AND a.user_id = ?
";
$stmt = $conn->prepare($question_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

$stmt->close();
$conn->close();

// Encode data into JSON format
header('Content-Type: application/json');
echo json_encode($questions);
?>
