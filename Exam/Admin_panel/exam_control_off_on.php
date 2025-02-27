<?php
// Include database connection
include '../../admin/config.php';
session_start();

// Handle toggle request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_status'])) {
    $status = $_POST['status'] == 'on' ? 1 : 0;

    // Update the status in the database
    $update_sql = "UPDATE exam_access_status SET status = ? WHERE id = 1";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $status);

    if ($stmt->execute()) {
        echo "<script>alert('Exam access status updated successfully.');</script>";
    } else {
        echo "<script>alert('Failed to update exam access status.');</script>";
    }

    $stmt->close();
}

// Fetch the current status of the exam access
$sql = "SELECT status FROM exam_access_status WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$status = $result->fetch_assoc()['status'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toggle Exam Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
        }
        .container h3 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #444;
        }
        .radio-group {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        .radio-option {
            margin: 0 15px;
        }
        .radio-option input[type="radio"] {
            margin-right: 8px;
            transform: scale(1.2);
        }
        button {
            background: #4caf50;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Toggle Exam Access</h3>
        <form method="POST">
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="on" name="status" value="on" <?php echo ($status == 1) ? 'checked' : ''; ?>>
                    <label for="on">On</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="off" name="status" value="off" <?php echo ($status == 0) ? 'checked' : ''; ?>>
                    <label for="off">Off</label>
                </div>
            </div>
            <button type="submit" name="toggle_status">Update Status</button>
        </form>
    </div>
</body>
</html>
