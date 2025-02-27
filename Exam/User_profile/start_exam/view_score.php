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

// Fetch all the data from `exam_answers` and `exam_questions` tables using JOIN
$sql = "
    SELECT 
        exam_answers.question_id, 
        exam_answers.answer AS user_answer,
        exam_questions.correct_answer
    FROM 
        exam_answers
    LEFT JOIN exam_questions ON exam_answers.question_id = exam_questions.question_no
    WHERE 
        exam_answers.user_id = ?
";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if data is found for the user
if ($result->num_rows == 0) {
    $message = "You could not attend the exam.Please participte the exam in timely.";
    $score = 0;
    $total_questions = 0;
    $percentage = 0;
    $comment = "";
} else {
    // Initialize score
    $score = 0;
    $total_questions = $result->num_rows;

    // Check user answers against correct answers
    while ($row = $result->fetch_assoc()) {
        // If the user's answer matches the correct answer, increase the score
        if (trim($row['user_answer']) == trim($row['correct_answer'])) {
            $score++;  // Increment score if answer is correct
        }
    }

    // Calculate percentage
    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;

    // Determine the comment based on the percentage
    if ($percentage >= 90) {
        $comment = "Excellent performance!";
    } elseif ($percentage >= 75) {
        $comment = "Good job!";
    } elseif ($percentage >= 50) {
        $comment = "Needs Improvement.";
    } else {
        $comment = "Better luck next time!";
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>View Score</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6D73B8, #354A70);
            margin: 0;
            padding: 0;
            color: #fff;
        }
        .container {
            width: 90%; /* Increased width for mobile */
            max-width: 700px; /* Max width for larger screens */
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #354A70;
        }
        .score, .percentage, .comment {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .score {
            font-size: 22px;
            color: #4CAF50;
            font-weight: bold;
        }
        .percentage {
            font-size: 20px;
            color: #FF9800;
        }
        .comment {
            font-size: 20px;
            font-weight: 600;
            color: #F44336;
        }
        .chart-container {
            width: 80%; /* Reduced width */
            max-width: 300px; /* Set a max width for larger screens */
            height: 300px; /* Set height for consistency */
            margin: 30px auto;
            display: flex;
            justify-content: center;
            position: relative;
        }
        .btn {
            display: inline-block;
            padding: 10px 25px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 30px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Your Score & Performance</h1>

        <?php if (isset($message)) { ?>
            <div class="comment">
                <p><?php echo $message; ?></p>
            </div>
        <?php } else { ?>
            <div class="score">
                <p>Your Score: <?php echo $score; ?> / <?php echo $total_questions; ?></p>
            </div>

            <div class="percentage">
                <p>Percentage: <?php echo number_format($percentage, 2); ?>%</p>
            </div>

            <div class="comment">
                <p><?php echo $comment; ?></p>
            </div>

            <!-- Display the score chart -->
            <div class="chart-container">
                <canvas id="scoreChart"></canvas>
            </div>
        <?php } ?>

        <!-- Button to go back -->
        <a href="../dashboard.php" class="btn">Go Back</a>
    </div>

    <script>
        var ctx = document.getElementById('scoreChart').getContext('2d');
        var scoreChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Correct Answers', 'Incorrect Answers'],
                datasets: [{
                    label: 'Your Performance',
                    data: [<?php echo $score; ?>, <?php echo $total_questions - $score; ?>],
                    backgroundColor: ['#4CAF50', '#FF5722'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' answers';
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Your Exam Performance',
                        font: {
                            size: 16
                        },
                        padding: 20,
                        color: '#354A70'
                    }
                },
                cutoutPercentage: 70, // Reduced donut width
                aspectRatio: 1, // Ensures the chart remains circular
            }
        });

        // Add score text inside the chart
        scoreChart.options.plugins.tooltip.enabled = false;
        scoreChart.options.plugins.doughnutlabel = {
            labels: [
                {
                    text: '<?php echo $score; ?>',
                    font: {
                        size: 30,
                        weight: 'bold'
                    },
                    color: '#354A70'
                }
            ]
        };
        scoreChart.update();
    </script>

</body>
</html>
