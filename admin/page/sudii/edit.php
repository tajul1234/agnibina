<?php
include '../../config.php';

$profileImagePath = '../../../member/sudi/uploads/';  // Base path for photo uploads

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch record data
    $sql = "SELECT * FROM arafat WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }
} else {
    echo "No ID specified.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update record data
    $mobile = $_POST['mobile'];
    $city = $_POST['city'];
    $amount = $_POST['amount'];
    $profession = $_POST['profession'];
    $comment = $_POST['comment'];
    $photo = $_FILES['photo'];

    // Handle photo upload
    if ($photo['tmp_name']) {
        $photoPath = $profileImagePath . basename($photo['name']);
        move_uploaded_file($photo['tmp_name'], $photoPath);
    } else {
        $photoPath = $row['photo']; // Keep current photo if not updated
    }

    // Update query
    $updateSql = "UPDATE arafat SET mobile = ?, city = ?, amount = ?, profession = ?, comment = ?, photo = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssdsssi", $mobile, $city, $amount, $profession, $comment, $photoPath, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully!";
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling for blurred and non-editable fields */
        .readonly-field {
            pointer-events: none;
            filter: blur(2px); /* Apply blur effect */
            background-color: #f8f9fa; /* Light background to show it's readonly */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Record</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="mt-4">
            <!-- Non-editable fields with blur effect -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['name']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="father_name" class="form-label">Father's Name</label>
                <input type="text" id="father_name" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['father_name']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" id="type" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['type']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="branch" class="form-label">Branch</label>
                <input type="text" id="branch" class="form-control readonly-field" value="<?php echo htmlspecialchars($row['branch']); ?>" readonly>
            </div>

            <!-- Editable fields -->
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo htmlspecialchars($row['mobile']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" class="form-control" value="<?php echo htmlspecialchars($row['city']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" id="amount" name="amount" class="form-control" value="<?php echo htmlspecialchars($row['amount']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" id="profession" name="profession" class="form-control" value="<?php echo htmlspecialchars($row['profession']); ?>">
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea id="comment" name="comment" class="form-control"><?php echo htmlspecialchars($row['comment']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" id="photo" name="photo" class="form-control">
                <?php if ($row['photo']): ?>
                    <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Current Photo" class="img-thumbnail mt-2" style="width: 100px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
