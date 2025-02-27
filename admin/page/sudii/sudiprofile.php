<?php
session_start();
include_once  '../../../admin/config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "SELECT * FROM arafat WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found!";
        exit;
    }
} else {
    echo "No user ID specified!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['name']); ?>'s Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #b0b0b0;
        }
        .profile-card {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            backdrop-filter: blur(10px); /* Glass effect */
        }
        .profile-img {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 6px solid rgba(0, 123, 255, 0.6);
        }
        .profile-info {
            margin-top: 20px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <?php
            $profileImagePath = '../../../member/sudi/uploads/';
            // Set the default image URL if no photo is found
            $defaultImage = 'data:image/jpeg;base64,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'; // Placeholder image URL
            
            $photoPath = !empty($user['photo']) && file_exists($profileImagePath . $user['photo']) 
                ? htmlspecialchars($profileImagePath . $user['photo']) 
                : $defaultImage; // Use the default image if no user photo is available
        ?>
        <img src="<?php echo $photoPath; ?>" alt="Profile Photo" class="profile-img">

        <h3 class="text-center"><?php echo htmlspecialchars($user['name']); ?>'s Profile</h3>
        <hr>

        <div class="profile-info">
            <div class="row">
                <div class="col-md-6">
                    <p><span class="info-label">Father's Name:</span> <span class="info-value"><?php echo htmlspecialchars($user['father_name']); ?></span></p>
                    <p><span class="info-label">Mobile Number:</span> <span class="info-value"><?php echo htmlspecialchars($user['mobile']); ?></span></p>
                    <p><span class="info-label">City:</span> <span class="info-value"><?php echo htmlspecialchars($user['city']); ?></span></p>
                    <p><span class="info-label">Profession:</span> <span class="info-value"><?php echo htmlspecialchars($user['profession']); ?></span></p>
                </div>
                <div class="col-md-6">
                    <p><span class="info-label">Amount:</span> <span class="info-value"><?php echo htmlspecialchars($user['amount']); ?></span></p>
                    <p><span class="info-label">Type:</span> <span class="info-value"><?php echo htmlspecialchars($user['type']); ?></span></p>
                    <p><span class="info-label">Branch:</span> <span class="info-value"><?php echo htmlspecialchars($user['branch']); ?></span></p>
                    <p><span class="info-label">Comment:</span> <span class="info-value"><?php echo htmlspecialchars($user['comment']); ?></span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
