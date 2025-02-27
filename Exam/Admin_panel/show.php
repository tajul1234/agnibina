<?php
// Start session to manage user login state
session_start();

// Check if the logout button is clicked
if (isset($_GET['logout'])) {
    // Destroy session and redirect to login page
    session_destroy();
    header('Location:../../../../../saad/index.php');
    exit();
}

// Include database connection
include('../../admin/config.php');

// Delete student logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Delete the student record
    $sql = "DELETE FROM dhumkhetu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = 'deleted';
    } else {
        $message = 'error';
    }
    $stmt->close();
}

// Get the approved student records
$result = $conn->query("SELECT * FROM dhumkhetu WHERE is_approved = 1");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Users</title>
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
            align-items: center; /* Vertically center the content */
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Dark background for the header */
            justify-content: space-between; /* Align "Show" link to the left */
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 30px;
            margin: 0;
            flex-grow: 1; /* Ensure the title is centered */
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.8); /* Black card-like background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #16a085;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #16a085; /* Table border color */
        }

        th {
            background-color: #16a085;
            color: white;
        }

        td {
            color: white; /* Text color in table cells */
        }

        td img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        td a {
            background-color: #16a085;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        td a:hover {
            background-color: #1abc9c;
        }

        td .reject {
            background-color: #e74c3c;
        }

        td .reject:hover {
            background-color: #c0392b;
        }

        .delete-button {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .message {
            text-align: center;
            padding: 10px;
            font-size: 18px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        h1 {
            text-align: center;
            padding: 20px;
            color: #fff;
        }

        .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <a href="?logout=true" class="logout-button">Logout</a>

    <h1>Approved Users</h1>

    <?php if (isset($message) && $message == 'error') { ?>
        <div class="message error">
            An error occurred. Please try again.
        </div>
    <?php } ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roll</th>
            <th>Class</th>
            <th>Group</th>
            <th>Picture</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><a href="profile.php?id=<?php echo $row['id']; ?>" style="color: white;"><?php echo $row['student_name']; ?></a></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['roll']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['group']; ?></td>
            <td><img src="../login_system/<?php echo $row['picture']; ?>" alt="Picture" width="50"></td>
            <td>
                <!-- Delete button with confirmation -->
                <a href="?delete=<?php echo $row['id']; ?>" class="delete-button" 
                   onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
