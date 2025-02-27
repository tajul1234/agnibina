<?php
session_start();
include_once('../config.php'); // Include your database connection settings

// Handle delete operation
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    
    $deleteQuery = "DELETE FROM trishal WHERE id = :id";
    $deleteStmt = $dbh->prepare($deleteQuery);
    $deleteStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
    $deleteStmt->execute();
}

// Fetch all users where subjects = 'kola'
$query = "SELECT * FROM trishal WHERE subjects = 'kola'";
$stmt = $dbh->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users with Type Kola</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #d3d3d3; /* Light gray background */
        }
        .container {
            margin-top: 50px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 96%; /* Width adjusted to 96% */
            max-width: 1600px; /* Maximum width */
            margin: 0 auto; /* Center the container */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Users with Type Kola</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Session</th>
                    <th>Department</th>
                    <th>Ward</th>
                    <th>Home Division</th>
                    <th>Home District</th>
                    <th>Blood Group</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['userName']); ?></td>
                            <td><?php echo htmlspecialchars($user['emailId']); ?></td>
                            <td><?php echo htmlspecialchars($user['ContactNumber']); ?></td>
                            <td><?php echo htmlspecialchars($user['session']); ?></td>
                            <td><?php echo htmlspecialchars($user['department']); ?></td>
                            <td><?php echo htmlspecialchars($user['subjects']); ?></td>
                            <td><?php echo htmlspecialchars($user['division']); ?></td>
                            <td><?php echo htmlspecialchars($user['district']); ?></td>
                            <td><?php echo htmlspecialchars($user['bloodGroup']); ?></td>
                            <td>
                                <div style="display: inline-flex; align-items: center;">
                                    <!-- Edit Button -->
                                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm mr-1">Edit</a>

                                    <!-- Delete Button -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">No records found for type 'kola'.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
