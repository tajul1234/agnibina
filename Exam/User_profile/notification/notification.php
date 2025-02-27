<?php
session_start();
include '../../../admin/config.php'; // Your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Delete notifications older than 1 month
$delete_sql = "DELETE FROM notifications WHERE user_id = ? AND created_at < NOW() - INTERVAL 1 MONTH";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();

// Fetch notifications for the user (unread first)
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>Notifications</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color:white;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
        }

        /* Notification section */
        .notification {
            background-color: #444;
            border: 1px solid #555;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .notification:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
        }

        .notification p {
            font-size: 1rem;
            color: #eee;
            margin: 0;
        }

        .notification small {
            display: block;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #bbb;
        }

        .see-more {
            color: #1e90ff;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
        }

        .see-more:hover {
            text-decoration: underline;
        }

        .no-notifications {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }

        /* Highlight unread notifications */
        .unread {
            background-color: #1e90ff;
            border: 1px solid #1e90ff;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .notification {
                padding: 10px;
                font-size: 0.9rem;
            }

            .notification small {
                font-size: 0.8rem;
            }

            .see-more {
                font-size: 0.9rem;
            }
        }

        .back-button {
            position: fixed;
            top: 10px;
            left: 10px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            background-color: #555;
            padding: 8px 12px;
            border-radius: 50px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button img {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }

        .back-button:hover {
            background-color: #666;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align:center">Notifications</h2>

    <?php if ($result->num_rows > 0): ?>
        <!-- Display notifications -->
        <?php while ($notification = $result->fetch_assoc()): ?>
            <div class="notification <?php echo ($notification['status'] == 'unread') ? 'unread' : ''; ?>" onclick="window.location.href='view_full_notification.php?id=<?php echo $notification['id']; ?>'">
                <p><?php echo substr($notification['message'], 0, 50) . "..."; ?></p>
                <a href="view_full_notification.php?id=<?php echo $notification['id']; ?>" class="see-more">See More</a>
                <small>Received: <?php echo date("d-m-Y h:i:s A", strtotime($notification['created_at'])); ?></small>
            </div>

            <?php
            $update_sql = "UPDATE notifications SET status = 'read' WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $notification['id']);
            $update_stmt->execute();
            ?>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-notifications">No new notifications.</p>
    <?php endif; ?>
</div>

<a href="../dashboard.php" class="back-button">
    <img src="https://img.icons8.com/material-outlined/24/ffffff/left.png" alt="Back Icon">
    Back
</a>

<?php
$stmt->close();
$delete_stmt->close();
$conn->close();
?>
</body>
</html>
