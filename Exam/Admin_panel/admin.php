


<?php
include('../../admin/config.php');

// Approve the user
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $sql = "UPDATE dhumkhetu SET is_approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Reject the user
if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $sql = "UPDATE dhumkhetu SET is_approved = -1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Get pending records
$result = $conn->query("SELECT * FROM dhumkhetu WHERE is_approved = 0");
?>

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
            background-image: url('back.webp');
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

        .add-exam-link {
            position: absolute;
            right: 20px;
            background-color: #16a085;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .add-exam-link:hover {
            background-color: #1abc9c;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #16a085;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #16a085;
        }

        th {
            background-color: #16a085;
            color: white;
        }

        td {
            color: white;
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

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                font-size: 14px;
                padding: 8px;
            }

            td img {
                max-width: 50px;
                max-height: 50px;
            }
        }

        .logout-button {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }
        .approve-all-button {
    position: fixed;
    bottom: 70px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #27ae60; /* Green */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
}

.approve-all-button:hover {
    background-color: #2ecc71;
}

    </style>
</head>
<body>
    
    <div class="header-container">
        <a href="show.php" class="show-link">Show</a>
        <h1>Admin Dashboard</h1>
        <!-- Add Exam button -->
        <a href="control_exam.php" class="add-exam-link">Add Exam</a>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roll</th>
            <th>Class</th>
            <th>Group</th>
            <th>Picture</th>
            <th>Approve</th>
            <th>Reject</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['student_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['roll']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td><?php echo $row['group']; ?></td>
            <td><img src="../login_system/<?php echo $row['picture']; ?>" alt="Picture" width="50"></td>
            <td><a href="?approve=<?php echo $row['id']; ?>">Approve</a></td>
            <td><a href="?reject=<?php echo $row['id']; ?>" class="reject">Reject</a></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Approve All Users Button -->
<a href="approve_all.php" class="approve-all-button">Approve All Users</a>

<!-- Logout Button -->
<a href="logout.php" class="logout-button">Logout</a>


</body>
</html>
