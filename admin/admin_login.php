<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: protect.php"); 
    exit();
}

$username = $_SESSION['username'];

include_once('config.php'); 


if (isset($_POST['confirm_user'])) {
    $userId = $_POST['user_id'];
    $email = $_POST['user_email'];

    $nameQuery = "SELECT name FROM users WHERE id = ?";
    $nameStmt = $conn->prepare($nameQuery);
    $nameStmt->bind_param("i", $userId);
    $nameStmt->execute();
    $result = $nameStmt->get_result();
    $user = $result->fetch_assoc();
    $userName = htmlspecialchars($user['name']);

   
    $updateQuery = "UPDATE users SET approved = 1 WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("i", $userId);
    $updateStmt->execute();

   
}

if (isset($_POST['reject_user'])) {
    $userId = $_POST['user_id'];

    
    $rejectQuery = "DELETE FROM users WHERE id = ?"; 
    $rejectStmt = $conn->prepare($rejectQuery);
    $rejectStmt->bind_param("i", $userId);
    $rejectStmt->execute();

    echo "<script>alert('User has been rejected successfully!');</script>";
}

$query = "SELECT id, name, email, contact_number, role, facebook_id, department, upazila, branch, type, district FROM users WHERE approved = 0"; // Updated query
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="mainadmin.css"> 
</head>
<body>
    <div class="container">
       <h3><a href="page/mainmember.php">Go to list</a></h3>
        <h1>Welcome, <?php echo $username; ?></h1>
        
        <h2>Pending Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Role</th>
                    <th>Facebook ID</th>
                    <th>Department</th>
                    <th>Type</th>
                    <th>Branch</th>
                    <th>Upozila</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="<?php echo htmlspecialchars($user['facebook_id']); ?>" target="_blank">
                            <?php echo htmlspecialchars($user['facebook_id']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($user['department']); ?></td>
                    <td><?php echo htmlspecialchars($user['type']); ?></td>
                    <td><?php echo htmlspecialchars($user['branch']); ?></td>
                    <td><?php echo htmlspecialchars($user['upazila']); ?></td>
                    <td><?php echo htmlspecialchars($user['district']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="user_email" value="<?php echo $user['email']; ?>">
                            <button type="submit" name="confirm_user" class="approve">Approve</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="reject"  name="reject_user" onclick="return confirm('Are you sure you want to reject this user?');">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
