

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login</title>
    <script>
  document.addEventListener('contextmenu', (event) => event.preventDefault());
</script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body, html {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('secure.png') no-repeat center center/cover;
        }

        .background {
            position: fixed;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(150%);
            border-radius: 12px;
            padding: 25px;
            width: 320px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            color: #333;
            text-align: center;
            transform: translateX(100%);
            animation: slideIn 0.8s ease-out forwards;
        }

        @keyframes slideIn {
            to {
                transform: translateX(0);
            }
        }

        .login-card h2 {
            margin-bottom: 15px;
            color: #fff;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        label {
            color: #fff;
            font-size: 14px;
            display: none; /* লেবেল লুকানো হয়েছে */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 12px 12px 40px; /* আইকনের জন্য জায়গা */
            border: none;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            color: #fff;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #ccc;
        }

        .icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            font-size: 1.2em;
            color: #fff;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2em;
            color: #fff;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #6c63ff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #554fbd;
        }

        .error-message {
            color: #ff4d4d;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="login-card">
            <h2>Login</h2>
            <form onsubmit="return validateLogin()">
                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="text" id="username" name="username" required placeholder="Enter your username">
                </div>
                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
                <button type="submit">Log In</button>
                <div id="error-message" class="error-message"></div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            const passwordType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', passwordType);
            toggleIcon.textContent = passwordType === 'password' ? '👁️' : '🙈';
        }

        function validateLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            if (username === 'tajul' && password === 'tajul') {
                window.location.href = 'admin.php';
                return false; 
            } else {
                errorMessage.textContent = 'Invalid username or password. Please try again.';
                return false; 
            }
        }
    </script>
</body>
</html>
