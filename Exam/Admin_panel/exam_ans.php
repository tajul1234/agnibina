<?php
// Include database connection
include '../../admin/config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through each submitted question and answer
    $questionNos = $_POST['question_no'];
    $answers = $_POST['correct_answer'];

    // Insert each question number and correct answer into the exam_questions table
    $stmt = $conn->prepare("INSERT INTO exam_questions (question_no, correct_answer) VALUES (?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    foreach ($questionNos as $index => $question_no) {
        $answer = $answers[$index];

        // Bind parameters and execute for each question-answer pair
        $stmt->bind_param("is", $question_no, $answer);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    }

    // Close the prepared statement
    $stmt->close();

    // Redirect to the same page to reload and show the data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch the questions and answers from the database
$sql = "SELECT question_no, correct_answer FROM exam_questions";
$result = $conn->query($sql);

if (!$result) {
    die('Query failed: ' . $conn->error); // Query error check
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Exam Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #f44336;
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-dashboard {
            display: block;
            width: 200px;
            margin: 30px auto;
            background-color: #2196F3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Insert Exam Answer</h1>
        <form method="POST" action="">
            <div id="questions-container">
                <div class="question-field">
                    <label for="question_no">Question Number 1:</label>
                    <input type="number" name="question_no[]" value="1" readonly>
                    <label for="correct_answer">Correct Answer:</label>
                    <select name="correct_answer[]">
                        <option value="ক">ক</option>
                        <option value="খ">খ</option>
                        <option value="গ">গ</option>
                        <option value="ঘ">ঘ</option>
                    </select>
                    <button type="button" class="btn btn-danger delete-question">Delete</button>
                </div>
            </div>
            <button type="button" class="btn" id="add-answer">Add Answer</button>
            <button type="submit" class="btn" id="submit-form">Submit</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
        <div>
            <h2>Questions and Answers</h2>
            <table>
                <thead>
                    <tr>
                        <th>Question Number</th>
                        <th>Correct Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['question_no']; ?></td>
                            <td><?php echo $row['correct_answer']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>No questions added yet.</p>
        <?php endif; ?>

        <a href="control_exam.php" class="btn btn-dashboard">Go to Dashboard</a>
    </div>

    <script>
        let questionCount = 1;

        // Update question numbers dynamically
        function updateQuestionNumbers() {
            const questionFields = document.querySelectorAll('#questions-container .question-field');
            questionFields.forEach((field, index) => {
                const questionInput = field.querySelector('input[name="question_no[]"]');
                questionInput.value = index + 1;
                const questionLabel = field.querySelector('label[for="question_no"]');
                questionLabel.textContent = `Question Number ${index + 1}:`;
            });
            questionCount = questionFields.length;
        }

        // Add a new question
        document.getElementById('add-answer').addEventListener('click', function () {
            questionCount++;
            const newQuestionField = document.createElement('div');
            newQuestionField.classList.add('question-field');
            newQuestionField.innerHTML = `
                <label for="question_no">Question Number ${questionCount}:</label>
                <input type="number" name="question_no[]" value="${questionCount}" readonly>
                <label for="correct_answer">Correct Answer:</label>
                <select name="correct_answer[]">
                    <option value="ক">ক</option>
                    <option value="খ">খ</option>
                    <option value="গ">গ</option>
                    <option value="ঘ">ঘ</option>
                </select>
                <button type="button" class="btn btn-danger delete-question">Delete</button>
            `;
            document.getElementById('questions-container').appendChild(newQuestionField);
        });

        // Delete a question and update numbers
        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('delete-question')) {
                e.target.parentElement.remove();
                updateQuestionNumbers();
            }
        });
    </script>
</body>
</html>
