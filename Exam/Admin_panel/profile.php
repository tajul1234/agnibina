<?php
include('../../admin/config.php');

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the student profile details
    $sql = "SELECT * FROM dhumkhetu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the record exists
    if ($row = $result->fetch_assoc()) {
        $student_name = $row['student_name'];
        $email = $row['email'];
        $roll = $row['roll'];
        $class = $row['class'];
        $group = $row['group'];
        $picture = $row['picture'];
    } else {
        echo "Student not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%; /* Ensure the height of html and body covers the full page */
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('back.webp'); /* Set the global background image */
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover; /* Cover the entire page */
            color: #fff;
        }

        .header-container {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Dark background for the header */
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 30px;
            margin: 0;
            flex-grow: 1;
        }

        .show-link {
            background-color: #16a085;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .show-link:hover {
            background-color: #1abc9c;
        }

        .profile-card {
            width: 60%;
            margin: 20px auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .profile-card img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-card h2 {
            color: #16a085;
        }

        .profile-card p {
            color: white;
            font-size: 18px;
        }

        .profile-card a {
            background-color: #16a085;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .profile-card a:hover {
            background-color: #1abc9c;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <a href="show.php" class="show-link">Back to Approved Users</a>
        <h1>Student Profile</h1>
    </div>

    <div class="profile-card">
        <img src="../login_system/<?php echo $picture; ?>" alt="Student Picture">
        <h2><?php echo $student_name; ?></h2>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Roll:</strong> <?php echo $roll; ?></p>
        <p><strong>Class:</strong> <?php echo $class; ?></p>
        <p><strong>Group:</strong> <?php echo $group; ?></p>
    </div>

</body>
</html>
