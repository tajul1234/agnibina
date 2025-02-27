<?php
// Database connection
include '../../../admin/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

// Get logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch all the data from `dhumkhetu` and `exam_answers` tables using JOIN
$sql = "
    SELECT 
        dhumkhetu.id AS user_id, 
        dhumkhetu.student_name, 
        dhumkhetu.roll, 
        dhumkhetu.email, 
        dhumkhetu.class, 
        exam_answers.question_id, 
        exam_answers.answer
    FROM 
        dhumkhetu
    LEFT JOIN exam_answers ON dhumkhetu.id = exam_answers.user_id
    WHERE 
        dhumkhetu.id = ?
";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store the data
$user_data = [];

while ($row = $result->fetch_assoc()) {
    // Store the user info only once
    if (empty($user_data)) {
        $user_data['user_info'] = [
            'user_id' => $row['user_id'],
            'student_name' => $row['student_name'],
            'roll' => $row['roll'],
            'email' => $row['email'],
            'class' => $row['class']
        ];
    }

    // Store the answers in an array, indexed by question
    $user_data['questions_answers'][] = [
        'question_id' => $row['question_id'],
        'answer' => $row['answer']
    ];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>Exam Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .user-info, .questions-answers {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
            color: #333;
        }
        .btn {
            display: block;
            width: fit-content;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .nav {
            text-align: right;
            margin-bottom: 10px;
        }
        .nav a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .nav a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Navigation with links to other pages -->
    

    <div class="container">
    <div class="nav">
        <a href="view_score.php" style>View your score</a>
    </div>
        <h1>Exam Success - User Information</h1>


        <!-- Display user information -->
        <div class="user-info">
            <h3>User Information:</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_data['user_info']['student_name']); ?></p>
            <p><strong>Roll:</strong> <?php echo htmlspecialchars($user_data['user_info']['roll']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['user_info']['email']); ?></p>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($user_data['user_info']['class']); ?></p>
        </div>

        <!-- Display questions and answers in a table -->
        <div class="questions-answers" id="questions-container">
            <h3>Questions and Your Answers:</h3>
            <table>
                <tr>
                    <th>Question Number</th>
                    <th>Your Answer</th>
                </tr>
                <?php 
                    if (!empty($user_data['questions_answers'])) {
                        foreach ($user_data['questions_answers'] as $qa) {
                            echo "<tr>";
                            echo "<td>Question No: " . htmlspecialchars($qa['question_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($qa['answer']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No answers available.</td></tr>";
                    }
                ?>
            </table>
        </div>

        <!-- Button to download questions as PDF -->
        <button class="btn" onclick="downloadPDF()">Download Questions</button>
    </div>

    <script>
        function downloadPDF() {
    fetch('download_question.php')
        .then(response => response.json())
        .then(data => {
            const container = document.createElement('div');
            container.innerHTML = `
                <div class="user-info" style="padding-left: 20px; text-align: center;">
                    <h3>User Information:</h3>
                    <p><strong>Name:</strong> ${<?php echo json_encode($user_data['user_info']['student_name']); ?>}</p>
                    <p><strong>Roll:</strong> ${<?php echo json_encode($user_data['user_info']['roll']); ?>}</p>
                    <p><strong>Email:</strong> ${<?php echo json_encode($user_data['user_info']['email']); ?>}</p>
                    <p><strong>Class:</strong> ${<?php echo json_encode($user_data['user_info']['class']); ?>}</p>
                </div>
                <div id="questions-container" style="padding-left: 20px; text-align: left;">
                    <h3>Questions and Answers:</h3>
                </div>
            `;

            const questionsContainer = container.querySelector('#questions-container');

            data.forEach((question, index) => {
                const questionHTML = `
                    <div style="padding-left: 20px; text-align: left;">
                        <p><strong>Q${index + 1}:</strong> ${question.question}</p>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div style="flex: 1; margin-right: 10px;">
                                <p><strong>ক.</strong> ${question.option1}</p>
                                <p><strong>খ.</strong> ${question.option2}</p>
                            </div>
                            <div style="flex: 1;">
                                <p><strong>গ.</strong> ${question.option3}</p>
                                <p><strong>ঘ.</strong> ${question.option4}</p>
                            </div>
                        </div>
                        <p><strong>Your Answer:</strong> ${question.user_answer}</p>
                    </div>
                    <hr>
                `;
                questionsContainer.innerHTML += questionHTML;
            });

            html2pdf()
                .from(container)
                .save('Exam_Questions_with_Your_Answers.pdf');
        })
        .catch(error => console.error('Error fetching questions:', error));
}

    </script>
</body>
</html>
