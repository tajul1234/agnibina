<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // If no session exists, redirect to login page
    header("Location:../login_system/login.php");
    exit;
}
?>



<?php
// Include database connection and menu
include '../../admin/config.php';
include 'menu.php';

// Function to log activities
function addActivity($conn, $user_id, $activity_type) {
    // Prepare the activity insertion query
    $insert_activity_sql = "INSERT INTO activities (user_id, activity_type, activity_time) VALUES (?, ?, ?)";
    $activity_time = date("Y-m-d H:i:s"); // Current timestamp
    
    // Prepare the statement
    $stmt = $conn->prepare($insert_activity_sql);
    $stmt->bind_param("iss", $user_id, $activity_type, $activity_time);
    
    // Execute the query
    $stmt->execute();
    $stmt->close();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_system/login.php");
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT * FROM dhumkhetu WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If the user is found, fetch their profile data
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $student_name = $user['student_name'];
    $email = $user['email'];
    $roll = $user['roll'];
    $class = $user['class'];
    $group = $user['group'];
    $picture = $user['picture'];
} else {
    echo "User not found!";
    exit;
}

// Call the function to log the login activity
addActivity($conn, $user_id, "Login"); // Activity type "Login"

// Fetch recent activities from the database (limit to 4)
$activity_sql = "SELECT * FROM activities WHERE user_id = ? ORDER BY activity_time DESC LIMIT 4";
$stmt_activity = $conn->prepare($activity_sql);
$stmt_activity->bind_param("i", $user_id);
$stmt_activity->execute();
$activity_result = $stmt_activity->get_result();

// Fetch all activities for the "See More" button
$all_activity_sql = "SELECT * FROM activities WHERE user_id = ? ORDER BY activity_time DESC";
$stmt_all_activity = $conn->prepare($all_activity_sql);
$stmt_all_activity->bind_param("i", $user_id);
$stmt_all_activity->execute();
$all_activity_result = $stmt_all_activity->get_result();

// Close the prepared statements and connection after all queries
$stmt_activity->close();
$stmt_all_activity->close();
$conn->close();
?>

<!-- The rest of your HTML code -->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    

    <title>Agnibina Online Exam Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    
</head>
<body>

    <div class="content">

        <!-- Top Bar -->
        <div class="top-bar d-flex justify-content-between align-items-center">
            <h1 class="mb-4 mm">Dashboard</h1>
            <div class="username d-flex align-items-center ms-auto">
                <!-- Display Profile Picture or Icon -->
                <?php if ($picture && file_exists('../login_system/' . $picture)): ?>
                    <img src="../login_system/<?php echo $picture; ?>" alt="Picture" width="70" height="70px" class="rounded-circle">
                <?php else: ?>
                    <i class="fas fa-user-circle fs-2"></i> <!-- Font Awesome Icon as fallback -->
                <?php endif; ?>
                <span class="p-2"><?= htmlspecialchars($student_name) ?></span>
            </div>
        </div>

        <!-- Exams Status Section -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card exam-card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Finished Exams</h5>
                        <p class="fs-3">1</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card exam-card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Dropped Exams</h5>
                        <p class="fs-3">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card exam-card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Total Exams</h5>
                        <p class="fs-3">1</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="card mb-4">
            <div class="card-body bg-dark text-white">
                <h3>Recent Activity</h3>
                <ul id="activity-list">
                    <?php if ($activity_result->num_rows > 0): ?>
                        <?php while ($activity = $activity_result->fetch_assoc()): ?>
                            <li><?= date("M d Y h:i A", strtotime($activity['activity_time'])) ?> (<?= $activity['activity_type'] ?>)</li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li>No recent activity.</li>
                    <?php endif; ?>
                </ul>
                <button id="see-more-btn" class="btn btn-info">See More</button>
            </div>
        </div>

        <!-- System Compatibility Section -->
        <div class="card">
            <div class="card-body bg-dark text-white text-center">
                <h3>Check System Compatibility</h3>
                <p>Ensure uninterrupted exam delivery by checking your system compatibility with our exam server.</p>
                <button> <a href="checkdevice.php" class="btn btn-info"> START CHECKING </a></button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!-- Footer -->
<!-- Footer -->
<div class="footer">
    <p>Please contact <a href="mailto:tajul.cse.jkkniu@gmail.com">tajul.cse.jkkniu@gmail.com</a> in case of any query.</p>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('see-more-btn').addEventListener('click', function() {
            var activityList = document.getElementById('activity-list');
            var seeMoreBtn = document.getElementById('see-more-btn');

            // Clear existing list and add all activities
            activityList.innerHTML = '';
            <?php while ($activity = $all_activity_result->fetch_assoc()): ?>
                var li = document.createElement('li');
                li.innerHTML = '<?= date("M d Y h:i A", strtotime($activity['activity_time'])) ?> (<?= $activity['activity_type'] ?>)';
                activityList.appendChild(li);
            <?php endwhile; ?>

            // Hide the 'See More' button after clicking
            seeMoreBtn.style.display = 'none';
        });
    </script>
</body>
</html>
