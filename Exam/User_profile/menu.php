<?php
include '../../admin/config.php'; // Your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Count unread notifications
$sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND status = 'unread'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$unread_count = $row['unread_count'];

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>Sidebar Menu</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS File -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color:#091057;
            color: white;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            font-family: Arial, sans-serif;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar h3 {
            font-size: 1.5rem;
            color: white;
            text-align: center;
        }

        .menu-link {
            display: block;
            padding: 10px 20px;
            color: #ddd;
            text-decoration: none;
            font-size: 1rem;
            margin: 5px 0;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .menu-link:hover {
            background-color: #495057;
            color: white;
        }

        .active {
            background-color: #007bff;
            color: white;
        }

        /* Notification Badge */
        .notification-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
            position: absolute;
            top: 5px;
            right: 5px;
        }

        /* Toggle button for mobile */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1100;
        }

        /* Media query for small screens */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%); /* Hide sidebar initially */
            }

            .sidebar.open {
                transform: translateX(0); /* Show sidebar when open */
            }

            .menu-toggle {
                display: block; /* Show toggle button */
            }
        }
    </style>
</head>
<body>

<!-- Toggle button -->
<button class="menu-toggle" onclick="toggleSidebar()">☰ Menu</button>

<!-- Sidebar -->
<div class="sidebar">
    <h3>Agnibina</h3>
    <a href="/saad/Exam/User_profile/dashboard.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) echo 'active'; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="/saad/Exam/User_profile/upcoming_exam.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'upcoming_exam.php') !== false) echo 'active'; ?>">
        <i class="fas fa-calendar-alt"></i> Upcoming Exam
    </a>
    <a href="/saad/Exam/User_profile/start_exam/condition.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'condition.php') !== false) echo 'active'; ?>">
        <i class="fas fa-play"></i> Start Exam
    </a>
    <a href="/saad/Exam/User_profile/exam_history.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'exam_history.php') !== false) echo 'active'; ?>">
        <i class="fas fa-history"></i> Exam History
    </a>
    <a href="/saad/Exam/User_profile/notification/notification.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'notification.php') !== false) echo 'active'; ?>">
        <i class="fas fa-bell"></i> Notification
        <?php if ($unread_count > 0): ?>
            <span class="notification-badge"><?php echo $unread_count; ?></span>
        <?php endif; ?>
    </a>
    <a href="/saad/Exam/User_profile/start_exam/view_score.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'view_score.php') !== false) echo 'active'; ?>">
        <i class="fas fa-book"></i> Your Score
    </a>
    <a href="/saad/Exam/User_profile/help.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'help.php') !== false) echo 'active'; ?>">
        <i class="fas fa-question-circle"></i> Help & Documentation
    </a>
    <a href="/saad/Exam/User_profile/user_account.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'user_account.php') !== false) echo 'active'; ?>">
        <i class="fas fa-user-circle"></i> My Account
    </a>
    <a href="/saad/Exam/User_profile/logout.php" class="menu-link <?php if(strpos($_SERVER['REQUEST_URI'], 'logout.php') !== false) echo 'active'; ?>">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('open');
    }
</script>

</body>
</html>
