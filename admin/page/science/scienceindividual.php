<?php
session_start();
include_once('../../config.php'); // Include your database connection settings

// Check if an ID is provided
if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit;
}

// Get the user ID from the URL
$userId = $_GET['id'];

// Fetch user details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId); // Bind the user ID as an integer
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['approved'] != 1) {
    echo "User not found or not approved.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #d3d3d3; /* Gray background color */
        }
        .container {
            margin-top: 50px;
            max-width: 800px; /* Center the container */
            background-color: #28a745; /* Green background color */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            color: purple; /* Text color set to purple */
        }
        h2 {
            margin-bottom: 30px;
            color: purple; /* Title color set to purple */
            text-align: center; /* Center the title */
        }
        .card {
            margin-bottom: 10px; /* Decreased gap between cards */
            border: none;
            border-radius: 10px;
            background-color: #f9f9f9; /* Card background color */
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #007bff;
            color: white; /* Card header text color remains white */
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center; /* Center the card header text */
        }
        .btn-primary {
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Profile</h2>

        <div class="card">
            <div class="card-header">Personal Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Name:</h5>
                        <p><?php echo htmlspecialchars($user['name']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Email:</h5>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Contact Number:</h5>
                        <p><?php echo htmlspecialchars($user['contact_number']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Facebook ID:</h5>
                        <p>
                            <a href="<?php echo htmlspecialchars($user['facebook_id']); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo htmlspecialchars($user['facebook_id']); ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Academic Details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Session:</h5>
                        <p><?php echo htmlspecialchars($user['session']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Faculty:</h5>
                        <p><?php echo htmlspecialchars($user['faculty']); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Department:</h5>
                        <p><?php echo htmlspecialchars($user['department']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Type:</h5>
                        <p><?php echo htmlspecialchars($user['type']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Location & Health</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Branch:</h5>
                        <p><?php echo htmlspecialchars($user['branch']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Division:</h5>
                        <p><?php echo htmlspecialchars($user['division']); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Home District:</h5>
                        <p><?php echo htmlspecialchars($user['district']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Upazila:</h5>
                        <p><?php echo htmlspecialchars($user['upazila']); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Blood Group:</h5>
                        <p><?php echo htmlspecialchars($user['blood_group']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status:</h5>
                        <p><?php echo htmlspecialchars($user['status']); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Role:</h5> <!-- Displaying the role field -->
                        <p><?php echo htmlspecialchars($user['role']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <a href="scienceall.php" class="btn btn-primary mt-3">Back to Users List</a>
    </div>
</body>
</html>
