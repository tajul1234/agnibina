<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('back.webp'); /* Add your background image */
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            color: #fff;
        }

        .header-container {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: space-between;
            position: relative;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 30px;
            margin: 0;
            flex-grow: 1;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Space between buttons */
            margin-top: 50px;
        }

        .button-link {
            background-color: #16a085;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .button-link:hover {
            background-color: #1abc9c;
        }

        .message {
            text-align: center;
            color: #16a085;
            margin-top: 20px;
            font-size: 18px;
        }

        /* Styling for the form (for future use) */
        .remove-data-form {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #e74c3c;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Buttons to add exam, remove data, and view results -->
    <div class="button-container">
    <a href="remove/video.php" class="button-link">Video</a>
       <a href="remove/add_question.php" class="button-link">Add Question</a>
        <a href="exam_ans.php" class="button-link">Add Answer</a>
      
        <a href="remove/view_result.php" class="button-link">Result</a> <!-- Added Result button -->
        <a href="remove/remove.php" class="button-link">Remove Data</a>
        <a href="remove/submit_notification.php" class="button-link">Sent Notification</a>
        <a href="exam_control_off_on.php" class="button-link">Exam Control By Off On</a>

       
    </div>

    <!-- Message (for feedback or success, can be used later) -->
    

</body>
</html>
