<?php
// Include database connection
include '../../../admin/config.php';
session_start();

// Handle form submission to update exam details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_details'])) {
    $subject = $_POST['subject'];
    $total_marks = $_POST['total_marks'];
    $exam_time = $_POST['exam_time'];

    // Update the database with new exam details
    $update_sql = "UPDATE exam_settings SET subject = ?, total_marks = ?, exam_time = ? WHERE id = 1";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sis", $subject, $total_marks, $exam_time);

    if ($stmt->execute()) {
        echo "<script>alert('Exam details updated successfully.');</script>";
    } else {
        echo "<script>alert('Failed to update exam details.');</script>";
    }

    $stmt->close();
}

// Handle form submission to insert questions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questions'])) {
    $totalQuestions = count($_POST['questions']);
    $successCount = 0;  // Variable to keep track of successfully inserted questions
    $errorCount = 0;    // Variable to keep track of failed insertions

    for ($i = 0; $i < $totalQuestions; $i++) {
        $questionNumber = $_POST['question_numbers'][$i];
        $question = $_POST['questions'][$i];

        // Loop through the options
        $option1 = isset($_POST['options'][$i*4]) ? $_POST['options'][$i*4] : '';
        $option2 = isset($_POST['options'][$i*4+1]) ? $_POST['options'][$i*4+1] : '';
        $option3 = isset($_POST['options'][$i*4+2]) ? $_POST['options'][$i*4+2] : '';
        $option4 = isset($_POST['options'][$i*4+3]) ? $_POST['options'][$i*4+3] : '';

        // Ensure that options are not null or empty
        if ($option1 && $option2 && $option3 && $option4) {
            // Prepare the SQL query
            $sql = "INSERT INTO questions (question_number, question, option1, option2, option3, option4) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error preparing query: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("isssss", $questionNumber, $question, $option1, $option2, $option3, $option4);

            // Execute the query
            if ($stmt->execute()) {
                $successCount++;  // Increment success count
            } else {
                $errorCount++;  // Increment error count
            }

            // Close the statement
            $stmt->close();
        } else {
            $errorCount++;  // Increment error count if options are missing
        }
    }

    // After all the questions are processed, show the alert
    if ($successCount > 0) {
        $message = "$successCount question(s) added successfully!";
    } else {
        $message = "No questions were added due to errors.";
    }

    if ($errorCount > 0) {
        $message .= " $errorCount question(s) had errors and were not added.";
    }

    // Display the alert and redirect after successful insertions
    echo "<script>
            alert('$message');
            window.location.href = '../admin.php';
          </script>";

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Exam Settings and Question Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .question-block {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f1f1f1;
            position: relative;
        }
        .question-block:hover {
            background-color: #e9ecef;
        }
        .btn-add-question,
        .btn-submit {
            width: 100%;
        }
        .btn-delete {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .input-with-color-box {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .color-box {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            background-color: #f0f0f0;
            margin-right: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Exam Details Form -->
<h2 class="text-center mb-4">Set Exam Details</h2>
<form method="POST">
    <div class="row mb-3">
        <label for="subject" class="col-md-4 col-form-label">Subject</label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="total_marks" class="col-md-4 col-form-label">Total Marks</label>
        <div class="col-md-8">
            <input type="number" class="form-control" id="total_marks" name="total_marks" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="exam_time" class="col-md-4 col-form-label">Exam Time (in minutes)</label>
        <div class="col-md-8">
            <input type="number" class="form-control" id="exam_time" name="exam_time" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary" name="exam_details">Save Exam Details</button>
        </div>
    </div>
</form>


        <!-- Question Form -->
        <h1 class="text-center mt-5">Add Questions</h1>
        <form method="POST" id="questionForm">
            <div id="questionContainer">
                <!-- Initial Question Block -->
                <div class="question-block" data-question-number="1">
                    <button type="button" class="btn-delete" onclick="deleteQuestion(this)">X</button>
                    <div class="mb-3">
                        <label class="form-label">Question Number:</label>
                        <input type="number" name="question_numbers[]" value="1" class="form-control" required readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Question:</label>
                        <input type="text" name="questions[]" class="form-control" placeholder="Enter question" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Options:</label>
                        <div class="input-with-color-box">
                            <div class="color-box">ক</div>
                            <input type="text" name="options[]" class="form-control" placeholder="Option 1" required>
                        </div>
                        <div class="input-with-color-box">
                            <div class="color-box">খ</div>
                            <input type="text" name="options[]" class="form-control" placeholder="Option 2" required>
                        </div>
                        <div class="input-with-color-box">
                            <div class="color-box">গ</div>
                            <input type="text" name="options[]" class="form-control" placeholder="Option 3" required>
                        </div>
                        <div class="input-with-color-box">
                            <div class="color-box">ঘ</div>
                            <input type="text" name="options[]" class="form-control" placeholder="Option 4" required>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success btn-add-question mb-3" onclick="addQuestion()">Add More Questions</button>
            <button type="submit" class="btn btn-primary btn-submit">Save Questions</button>
        </form>
    </div>

    <script>
        let questionCount = 1;  // Initialize starting question number

        function addQuestion() {
            const container = document.getElementById('questionContainer');
            const newBlock = document.createElement('div');
            newBlock.classList.add('question-block');
            newBlock.setAttribute('data-question-number', questionCount);  // Use sequential question numbers
            newBlock.innerHTML = `
                <button type="button" class="btn-delete" onclick="deleteQuestion(this)">X</button>
                <div class="mb-3">
                    <label class="form-label">Question Number:</label>
                    <input type="number" name="question_numbers[]" value="${questionCount}" class="form-control" required readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Question:</label>
                    <input type="text" name="questions[]" class="form-control" placeholder="Enter question" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Options:</label>
                    <div class="input-with-color-box">
                        <div class="color-box">ক</div>
                        <input type="text" name="options[]" class="form-control" placeholder="Option 1" required>
                    </div>
                    <div class="input-with-color-box">
                        <div class="color-box">খ</div>
                        <input type="text" name="options[]" class="form-control" placeholder="Option 2" required>
                    </div>
                    <div class="input-with-color-box">
                        <div class="color-box">গ</div>
                        <input type="text" name="options[]" class="form-control" placeholder="Option 3" required>
                    </div>
                    <div class="input-with-color-box">
                        <div class="color-box">ঘ</div>
                        <input type="text" name="options[]" class="form-control" placeholder="Option 4" required>
                    </div>
                </div>
            `;
            container.appendChild(newBlock);
            questionCount++;  // Increment question number
        }

        function deleteQuestion(button) {
            const questionBlock = button.closest('.question-block');
            questionBlock.remove();
        }
    </script>
</body>
</html>
