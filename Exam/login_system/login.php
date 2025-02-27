<?php
session_start();
include '../../admin/config.php'; // Include database connection

// CSRF টোকেন তৈরি
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Flash Message Function
function set_flash_message($message) {
    $_SESSION['flash_message'] = $message;
}

function display_flash_message() {
    if (!empty($_SESSION['flash_message'])) {
        echo "<script>alert('" . $_SESSION['flash_message'] . "');</script>";
        unset($_SESSION['flash_message']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CSRF টোকেন যাচাই
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash_message('Invalid CSRF token.');
        header('Location: login.php');
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // ইউজার তথ্য চেক করা
    $sql = "SELECT * FROM dhumkhetu WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // পাসওয়ার্ড যাচাই করা
        if (password_verify($password, $user['password'])) {
            if ($user['is_approved'] == 1) {
                $_SESSION['user_id'] = $user['id'];
                set_flash_message('Login successful!');
                echo "<script>window.location.href = '../User_profile/user_account.php?id=" . $user['id'] . "';</script>";
            } else {
                set_flash_message('Your account is not approved yet. Please wait for admin approval.');
            }
        } else {
            set_flash_message('Invalid email or password. Please try again.');
        }
    } else {
        set_flash_message('No account found with this email. Please sign up first.');
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
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Background styling */
       
    body {
        background-image: url('bac.jpg'); /* Background Image */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
        backdrop-filter: blur(10px); /* Background blur for glass effect */
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border */
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        position: relative;
        text-align: center;

        /* Animation */
        animation: slide-in 1s ease-out forwards;
    }

    @keyframes slide-in {
        from {
            transform: translateX(100%); /* Start off-screen */
            opacity: 0;
        }
        to {
            transform: translateX(0); /* Center */
            opacity: 1;
        }
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #16a085;
        box-shadow: 0 0 15px rgba(22, 160, 133, 0.5);
    }

    .form-control {
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.2); /* Transparent background */
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form-control:focus {
        border-color: #16a085;
        box-shadow: 0 0 5px rgba(22, 160, 133, 0.7);
    }

    .btn {
        background-color: #16a085;
        color: white;
    }

    .btn:hover {
        background-color: #1abc9c;
    }

    .btn-outline-success {
        border: none;
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(22, 160, 133, 0.7);
    }

    @media screen and (max-width: 768px) {
        .card {
            padding: 15px;
            max-width: 300px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .btn {
            font-size: 14px;
        }
    }
</style>

    </style>
</head>
<body>
    <?php display_flash_message(); ?>
    <div class="container">
        <div class="card">
            <div class="logo-container">
                <img src="logo.jpeg" alt="Logo" class="logo">
            </div>
            <h2 class="text-center text-white mb-4">Student Login</h2>
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-dark text-white"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-dark text-white"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    <span class="input-group-text bg-dark text-white">
                        <i id="togglePassword" class="fas fa-eye"></i>
                    </span>
                </div>
                <button type="submit" class="btn btn-outline-success btn-lg w-100">Login</button>
                <p class="text-center mt-3" style="color: aliceblue;">Don't have an account? 
                    <a href="signup.php" style="color: #16a085;">Sign up</a>
                </p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            const passwordFieldType = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", passwordFieldType);
            this.classList.toggle("fa-eye-slash");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
