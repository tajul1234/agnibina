<?php
session_start();
include_once('../config.php'); 

if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleteQuery = "DELETE FROM users WHERE id = ?"; 
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param('i', $deleteId);
    $deleteStmt->execute();
}

$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    $query = "SELECT * FROM users WHERE 
              approved = 1 AND 
              status = 'active' AND
              (name LIKE ? OR 
              email LIKE ? OR 
              faculty LIKE ? OR 
              department LIKE ? OR 
              role LIKE ?)";

    $stmt = $conn->prepare($query);
    $searchParam = '%' . $searchTerm . '%';
    $stmt->bind_param('sssss', $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
} else {
    $query = "SELECT * FROM users WHERE approved = 1 AND status = 'active'";
    $stmt = $conn->prepare($query);
}
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Approved Users List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #f0f8ff, #e6e6fa);
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 30px;
            max-width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        h2 {
            color: #4a90e2;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        tbody tr:nth-child(even) {
            background-color: #e6f7ff;
        }
        .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
        }
        .btn-primary:hover {
            background-color: #357abd;
        }
        .btn-danger {
            background-color: #e94e77;
            border-color: #e94e77;
        }
        .btn-danger:hover {
            background-color: #c72f5a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">আমাদের সকল জনশক্তি</h2>


        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Name, Email, Faculty, Department, মান">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Session</th>
                    <th>Faculty</th>
                    <th>Department</th>
                    <th>মান</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td>
                                <a href="individual.php?id=<?php echo htmlspecialchars($user['id']); ?>">
                                    <?php echo htmlspecialchars($user['name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($user['session']); ?></td>
                            <td><?php echo htmlspecialchars($user['faculty']); ?></td>
                            <td><?php echo htmlspecialchars($user['department']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <div style="display: inline-flex;">
                                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm mr-1">Edit</a>
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
                        <td colspan="9" class="text-center">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
