<?php
// Database connection
include '../../../admin/config.php';

// Fetch the marks, correct answers, wrong answers, and position of each user
$sql = "
    SELECT 
        dhumkhetu.student_name, 
        dhumkhetu.roll, 
        dhumkhetu.email,
        dhumkhetu.picture, 
        SUM(CASE WHEN exam_answers.answer = exam_questions.correct_answer THEN 1 ELSE 0 END) AS correct_answers,
        COUNT(exam_answers.answer) - SUM(CASE WHEN exam_answers.answer = exam_questions.correct_answer THEN 1 ELSE 0 END) AS wrong_answers,
        SUM(CASE WHEN exam_answers.answer = exam_questions.correct_answer THEN 1 ELSE 0 END) AS marks
    FROM 
        exam_answers
    JOIN 
        dhumkhetu ON exam_answers.user_id = dhumkhetu.id
    JOIN 
        exam_questions ON exam_answers.question_id = exam_questions.question_no
    GROUP BY 
        dhumkhetu.id
    ORDER BY 
        marks DESC
";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Results</title>
    <style>
        /* Basic reset */
        body {
    background-color: darkslategray;
    font-family: Arial, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container for the page */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

/* Card-style container around the table */
.card {
    background: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Table and border color */
table, th, td {
    border: 2px solid #0066cc; /* Set the border color to blue */
}

th, td {
    padding: 12px;
    text-align: center; /* Center text in both header and data cells */
}

th {
    font-weight: bold;
    background-color: #0066cc;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #e2e2e2;
}

/* Table cell for profile picture */
.profile-picture {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

/* Button styling */
.buttons {
    margin: 20px 0;
    text-align: center;
}

.buttons button {
    padding: 10px 20px;
    margin: 10px;
    background-color: #0066cc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.buttons button:hover {
    background-color: #005bb5;
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    /* Table cell for profile picture */
/* Table cell for profile picture */
.profile-picture {
    width: 100px;  /* Increase the width to 100px */
    height: 100px; /* Increase the height to 100px */
    border-radius: 50%; /* Make it round */
}


}

    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; color: white;">User Exam Results</h2>
        
        <?php
        if ($result->num_rows > 0) {
            // Wrap the table in a card-like container
            echo "<div class='card'>
                    <table id='resultTable'>
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Roll</th>
                                <th>Email</th>
                                <th>Right Answers</th>
                                <th>Wrong Answers</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>";
            $position = 1; // Starting position

            // Loop through the results and display each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $position . "</td>
                        <td><img src='../../login_system/" . $row['picture'] . "' class='profile-picture' alt='Profile Picture'></td>
                        <td>" . $row['student_name'] . "</td>
                        <td>" . $row['roll'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['correct_answers'] . "</td>
                        <td>" . $row['wrong_answers'] . "</td>
                        <td>" . $row['marks'] . "</td>
                    </tr>";
                $position++; // Increment position
            }

            echo "</tbody></table></div>"; // Close table and card
        } else {
            echo "<p style='color: white;'>No results found.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
        
        <!-- Buttons for Print and Download -->
        <div class="buttons">
            <button onclick="downloadPDF()">Download PDF</button>
        </div>
    </div>

    <!-- jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script>
    // Function to download the table as PDF with images
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Temporarily increase the size of profile pictures
        let originalSize = document.querySelectorAll('.profile-picture');
        originalSize.forEach(picture => {
            picture.style.width = '60px';  // Increase width to 60px
            picture.style.height = '60px'; // Increase height to 60px
        });

        // Get the table element
        const table = document.getElementById('resultTable');
        
        // Use html2canvas to capture the table as a base64 image
        html2canvas(table, {
            onrendered: function(canvas) {
                const imgData = canvas.toDataURL('image/png'); // Convert canvas to image data
                doc.addImage(imgData, 'PNG', 10, 10, 180, 0); // Adjust positioning and size
                doc.save('exam_results_with_images.pdf');
                
                // Restore the original size of profile pictures
                originalSize.forEach(picture => {
                    picture.style.width = '';  // Reset to original width
                    picture.style.height = ''; // Reset to original height
                });
            }
        });
    }
</script>

</body>
</html>
