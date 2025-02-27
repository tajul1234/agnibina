<?php
include '../../admin/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $roll = $_POST['roll'];
    $class = $_POST['class'];
    $group = $_POST['group'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $picture = '';

    if (!empty($_FILES['picture']['name'])) {
        $target_dir = "uploads/";
        $picture = $target_dir . basename($_FILES['picture']['name']);
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    $sql = "INSERT INTO dhumkhetu (student_name, email, roll, class, `group`, picture, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissss", $student_name, $email, $roll, $class, $group, $picture, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Thank You! Signup successful! Wait for admin approval. Are you ready to login?');
                  {
                    window.location.href = 'login.php'; 
                      }
              </script>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .input-group-text {
            background-color: #007bff;
            color: white;
        }

        .form-control {
            border: 2px solid #007bff;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 0, 255, 0.5);
        }

        .signup-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        .signup-container {
            background: url('im.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }

        .signup-card {
            max-width: 900px;
            margin: auto;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-outline-success, .btn-outline-secondary {
            padding: 6px 10px;
        }

        /* Message styles */
        .done-message {
            color: green;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
        .mm{
            width: 400px;
        }
        
        
    </style>
</head>
<body>
    <div class="signup-container d-flex align-items-center justify-content-center">
        <div class="signup-card row g-0">
            <div class="col-md-6 left-section d-flex flex-column align-items-center justify-content-center text-center">
                <img src="cartoon.avif" alt="Signup Image" class="img-fluid" style="max-width: 90%;">
                <h3>Welcome! Let's Get You Started.</h3>
            </div>
            <div class="col-md-6 right-section p-4">
                <div class="form-container">
                    <h2 class="mb-4">Create an Account</h2>
                    <form action="signup.php" method="POST" enctype="multipart/form-data" id="signupForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="studentName" class="form-label" style="color:aliceblue">Student Name :*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="studentName" name="student_name" placeholder="Enter your name" required>
                                    <span id="studentNameMsg"></span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label" style="color:aliceblue">Email :*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                    <span id="emailMsg"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="roll" class="form-label" style="color:aliceblue">Roll :*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                                    <input type="number" class="form-control" id="roll" name="roll" placeholder="Enter your roll number" required>
                                    <span id="rollMsg"></span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="class" class="form-label" style="color:aliceblue">Class</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                    <input type="text" class="form-control" id="class" name="class" placeholder="Enter your class" required>
                                    <span id="classMsg"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="group" class="form-label" style="color:aliceblue">Group</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <select class="form-select" id="group" name="group" required>
                                        <option value="" disabled selected>Select your group</option>
                                        <option value="Science">Science</option>
                                        <option value="Arts">Arts</option>
                                        <option value="Commerce">Commerce</option>
                                    </select>
                                    <span id="groupMsg"></span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="picture" class="form-label" style="color:aliceblue">Upload Picture</label>
                                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label" style="color:aliceblue">Password :*</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                                    <button type="button" class="btn btn-outline-success" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <span id="passwordMsg"></span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="confirmPassword" class="form-label" style="color:aliceblue">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <span id="confirmPasswordMsg"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-outline-success btn-lg mm" id="submitBtn">Signup</button>
                        </div>
                       <h6>Already have an account?  <a href="login.php">Login</a></h6> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirmPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.querySelector('i').classList.toggle('bi-eye');
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordField.type === 'password' ? 'text' : 'password';
            confirmPasswordField.type = type;
            this.querySelector('i').classList.toggle('bi-eye');
        });

        // Check if passwords match
        confirmPasswordField.addEventListener('input', function() {
            const passwordMsg = document.getElementById('confirmPasswordMsg');
            if (passwordField.value !== confirmPasswordField.value) {
                passwordMsg.textContent = 'Password not match';
                passwordMsg.style.color = 'red';
            } else {
                passwordMsg.textContent = 'Done!';
                passwordMsg.style.color = 'green';
            }
        });

        // Show "Done!" for all fields if filled correctly
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            let isValid = true;
            let fields = document.querySelectorAll('.form-control');
            fields.forEach(field => {
                if (field.value.trim() !== '') {
                    const messageElement = document.getElementById(field.id + 'Msg');
                    if (messageElement) {
                        messageElement.textContent = 'Done!';
                        messageElement.style.color = 'green';
                    }
                } else {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Please fill out all required fields');
            }
        });

        document.getElementById('signupForm').addEventListener('submit', function(event) {
    const pictureField = document.getElementById('picture');
    const picture = pictureField.files[0];

    if (picture) {
        const fileType = picture.type.split('/')[0];
        if (fileType !== 'image') {
            event.preventDefault(); // Prevent form submission
            alert('Please upload only image files.');
            pictureField.value = ''; // Clear the file input
        }
    }
});

    </script>

</body>
</html>
