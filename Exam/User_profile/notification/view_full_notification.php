<?php
session_start();
include '../../../admin/config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID
$notification_id = $_GET['id']; // Get the notification ID from URL

// Fetch the full notification for the user
$sql = "SELECT * FROM notifications WHERE user_id = ? AND id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $notification_id);
$stmt->execute();
$result = $stmt->get_result();

// HTML Structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
       body {
    font-family: 'Poppins', sans-serif;
    background-color: #eef3f8;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #2c3e50;
    font-size: 0.9rem;
    font-weight: 600;
    background-color: #fff;
    padding: 10px 15px;
    border-radius: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.back-button img {
    width: 20px;
    height: 20px;
    margin-right: 8px;
}

.back-button:hover {
    background-color: #f1f1f1;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.notification-container {
    background-color: #fff;
    border-radius: 12px;
    padding: 30px;
    width: 90%; /* Ensure proper scaling on smaller screens */
    max-width: 600px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    text-align: left;
    margin: 20px;
}

h3 {
    font-size: 1.6rem;
    font-weight: bold;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

.notification-content {
    background: #f9f9f9;
    padding: 20px;
    border-left: 5px solid #3498db;
    border-radius: 8px;
    margin-top: 10px;
}

.notification-content p {
    font-size: 1rem;
    color: #4a4a4a;
    line-height: 1.6;
    margin: 0;
}

.notification-content small.date {
    display: block;
    margin-top: 15px;
    font-size: 0.85rem;
    color: #7d7d7d;
    text-align: right;
}

.no-notification {
    text-align: center;
    font-size: 1.1rem;
    color: #999;
}

/* Responsive Design */
@media (max-width: 768px) {
    .notification-container {
        padding: 20px;
        width: 95%; /* More compact on smaller screens */
    }

    h3 {
        font-size: 1.4rem;
    }

    .notification-content p {
        font-size: 0.95rem;
    }

    .back-button {
        font-size: 0.8rem;
        padding: 8px 12px;
    }

    .back-button img {
        width: 18px;
        height: 18px;
    }
}

@media (max-width: 480px) {
    .notification-container {
        padding: 15px;
    }

    h3 {
        font-size: 1.2rem;
    }

    .notification-content p {
        font-size: 0.9rem;
    }

    .back-button {
        font-size: 0.75rem;
        padding: 6px 10px;
    }

    .back-button img {
        width: 16px;
        height: 16px;
    }
}

    </style>
</head>
<body>
    <a href="notification.php" class="back-button">
        <img src="https://img.icons8.com/ios-filled/50/3498db/left.png" alt="Back Icon">
        Back
    </a>

    <?php if ($result->num_rows > 0): 
        $notification = $result->fetch_assoc(); ?>
        <div class="notification-container">
            <h3>Notification</h3>
            <div class="notification-content">
                <p><?= nl2br($notification['message']) ?></p>
                <small class="date">Received on: <?= $notification['created_at'] ?></small>
            </div>
        </div>
        <?php
        // Mark as read
        $update_sql = "UPDATE notifications SET status = 'read' WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $notification['id']);
        $update_stmt->execute();
        $update_stmt->close();
    else: ?>
        <p class="no-notification">Notification not found.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
