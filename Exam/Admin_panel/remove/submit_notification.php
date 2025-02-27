<?php
session_start();
include '../../../admin/config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $user_ids = $_POST['user_ids']; // User selection from the form

    // Check if no users are selected
    if (empty($user_ids)) {
        die("Error: No users selected.");
    }

    if (in_array('all', $user_ids)) {
        // Send notification to all users
        $sql = "SELECT id FROM dhumkhetu";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $user_id = $row['id'];
            $insert_sql = "INSERT INTO notifications (user_id, message, status, created_at) VALUES (?, ?, 'unread', NOW())";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("is", $user_id, $message);
            $stmt->execute();
        }
    } else {
        // Send notification to selected users
        foreach ($user_ids as $user_id) {
            $insert_sql = "INSERT INTO notifications (user_id, message, status, created_at) VALUES (?, ?, 'unread', NOW())";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("is", $user_id, $message);
            $stmt->execute();
        }
    }

    echo "Notifications sent successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications</title>
    <!-- CSS for Select2 and Quill -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #editor-container {
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background: #007BFF;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Send Notification</h2>
    <form method="POST" action="">
        <label for="user_ids">Select Users:</label>
        <select name="user_ids[]" id="user_ids" class="select2-multiple" multiple="multiple" style="width: 100%;">
            <?php
            // Fetch all users
            $sql = "SELECT id, student_name FROM dhumkhetu"; // Your users table
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['student_name'] . "</option>";
                }
            } else {
                echo "<option disabled>No Users Available</option>";
            }
            ?>
            <option value="all">All Users</option>
        </select>

        <label for="message">Notification Message:</label>
        <div id="editor-container"></div>
        <input type="hidden" name="message" id="message">

        <input type="submit" value="Send Notification">
    </form>
</div>

<!-- JS for Select2 and Quill -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<script>
    // Initialize Select2
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "Select users or type 'All Users'",
            allowClear: true
        });
    });

    // Initialize Quill
    var quill = new Quill('#editor-container', {
        theme: 'snow'
    });

    // Save the content to a hidden input field
    document.querySelector('form').onsubmit = function() {
        document.querySelector('#message').value = quill.root.innerHTML;
    };
</script>

</body>
</html>
