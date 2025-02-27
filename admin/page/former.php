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
              status = 'former' AND 
              (name LIKE ? OR 
              email LIKE ? OR 
              department LIKE ? OR 
              branch LIKE ?)";
    
    $stmt = $conn->prepare($query);
    $searchParam = '%' . $searchTerm . '%';
    $stmt->bind_param('ssss', $searchParam, $searchParam, $searchParam, $searchParam);
} else {
    // Fetch all approved former users if no search term is provided
    $query = "SELECT * FROM users WHERE approved = 1 AND status = 'former'";
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
    <title>Former Users List</title>
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
            padding: 6px; /* Decreased padding for compactness */
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

        
        .department, .branch {
            width: 50px; /* Decreased width */
        }

        .name {
            width: 250px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
        }

        .email {
            width: 150px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Former USERS</h2>
        
        <!-- Search Bar -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Name, Email, Department, or Branch" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="name">Name</th>
                    <th class="email">Email</th>
                    <th>Contact Number</th>
                    <th>Session</th>
                    <th class="department">Department</th>
                    <th class="branch">Branch</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="name"><a href="individualformer.php?id=<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></a></td>
                            <td class="email"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($user['session']); ?></td>
                            <td class="department"><?php echo htmlspecialchars($user['department']); ?></td>
                            <td class="branch"><?php echo htmlspecialchars($user['branch']); ?></td>
                            <td>
                                <div style="display: inline-flex; align-items: center;">
                                   
                                    <a href="editformer.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm mr-1">Edit</a>

                                   
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
                        <td colspan="8" class="text-center">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
