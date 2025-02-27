<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // If no session exists, redirect to login page
    header("Location:../login_system/login.php");
    exit;
}
?>



<?php
include '../../admin/config.php';
include 'menu.php';

// Get user ID from session or URL
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_GET['id'];

// Fetch user details
$sql = "SELECT * FROM dhumkhetu WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// If the user is found, display their profile
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

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo1.png" type="image/png">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
  /* Set background image for the entire page */
body {
    font-family: 'Poppins', sans-serif;
    background-image: url('p.jpg'); /* Path to your background image */
    background-size: cover; /* Ensure the image covers the entire page */
    background-position: center; /* Center the background image */
    background-attachment: fixed; /* Keep the background fixed while scrolling */
}

/* Gray profile card with white text */
.profile-card {
    background-color: #6c757d; /* Gray background */
    color: white; /* White text */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Center the profile picture */
#profileImage {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 150px;
    height: 150px;
    border-radius: 50%;
}

/* Glass effect for the menu bar on mobile screens */
@media (max-width: 768px) {
    .navbar {
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent white background */
        backdrop-filter: blur(10px); /* Glass effect */
        -webkit-backdrop-filter: blur(10px); /* For Safari */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Light border */
    }

    .navbar-nav .nav-link {
        color: white !important; /* White text for menu items */
    }

    /* Style for mobile profile card */
    .profile-card {
        background-color: rgba(108, 117, 125, 0.7); /* Semi-transparent gray for mobile */
        color: white;
    }
}

        </style>
</head>
<body>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="header-container text-center mb-4">
            <h1>Student Profile</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="profile-card card shadow-sm p-4">
                    <img src="../login_system/<?php echo $picture; ?>" alt="Student Picture" id="profileImage" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <h2 class="text-center"><?php echo $student_name; ?></h2>
                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                    <p><strong>Roll:</strong> <?php echo $roll; ?></p>
                    <p><strong>Class:</strong> <?php echo $class; ?></p>
                    <p><strong>Group:</strong> <?php echo $group; ?></p>
                    <hr>
                    <!-- Form to upload new profile picture -->
                    <p>Upload/change picture</p>
                    <div class="upload-box">
                        <form action="update_picture.php" method="POST" enctype="multipart/form-data" id="uploadForm">
                            <label for="profile_picture" class="upload-label">Upload Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control mb-2" accept="image/*">
                            <div id="loadingIndicator" class="loading-indicator" style="display:none;">
                                <div class="progress">
                                    <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div> <!-- Loading Progress Bar -->
                            <button type="submit" class="btn btn-primary mt-2 w-100" id="uploadBtn" disabled>Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer text-center py-3">
        <p>&copy; 2024 Agnibina. Contact <a href="mailto:businessid1977@gmail.com">businessid1977@gmail.com</a> for support.</p>
    </div>

    <!-- JavaScript -->
    <script>
    document.getElementById('profile_picture').addEventListener('change', function () {
        var fileInput = document.getElementById('profile_picture');
        var uploadBtn = document.getElementById('uploadBtn');
        var loadingIndicator = document.getElementById('loadingIndicator');
        var progressBar = document.getElementById('progressBar');
        var rotateBtn = document.getElementById('uploadBtn');

        // Show the upload button and loading indicator only after a file is selected
        if (fileInput.files.length > 0) {
            uploadBtn.disabled = false;
            loadingIndicator.style.display = 'block'; // Show loading indicator
            rotateBtn.classList.add('rotating'); // Start rotating button
        }
    });

    // Handle file upload when the Upload button is clicked
    document.getElementById('uploadForm').addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent the default form submission

        var fileInput = document.getElementById('profile_picture');
        var uploadBtn = document.getElementById('uploadBtn');
        var loadingIndicator = document.getElementById('loadingIndicator');
        var progressBar = document.getElementById('progressBar');
        var rotateBtn = document.getElementById('uploadBtn');

        // Show the loading progress bar and disable the button
        loadingIndicator.style.display = 'block';
        uploadBtn.disabled = true;
        rotateBtn.classList.add('rotating'); // Rotate button while uploading

        // Simulate file upload progress
        var progress = 0;
        var interval = setInterval(function () {
            progress += 10;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);

            // Change progress bar color based on the progress
            if (progress < 50) {
                progressBar.classList.remove('success', 'danger');
                progressBar.classList.add('warning');
            } else if (progress < 100) {
                progressBar.classList.remove('success', 'warning');
                progressBar.classList.add('danger');
            } else {
                progressBar.classList.remove('warning', 'danger');
                progressBar.classList.add('success');
                rotateBtn.classList.remove('rotating');
                uploadBtn.disabled = false;  // Enable the upload button
                clearInterval(interval); // Stop the progress simulation

                // Show the uploaded picture (simulate)
                document.getElementById('profileImage').src = URL.createObjectURL(fileInput.files[0]);
            }
        }, 300);  // Simulate progress every 300ms

        // Actual file upload logic here (AJAX request or Form submission)
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", this.action, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Image upload success
                document.getElementById('profileImage').src = URL.createObjectURL(fileInput.files[0]);
            } else {
                alert('Error uploading file!');
            }
        };
        xhr.send(formData);
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
