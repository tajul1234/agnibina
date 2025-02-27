<?php
include '../config.php'; 


$id = $_GET['id']; 
$name = $email = $cnumber = $facebookId = $password = "";
$role = $session = $faculty = $department = $division = $district = $upazila = $bloodGroup = $status = "";
$type = $branch = "";


if ($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $cnumber = $row['contact_number'];
        $role = $row['role'];
        $facebookId = $row['facebook_id'];
        $session = $row['session'];
        $faculty = $row['faculty'];
        $department = $row['department'];
        $division = $row['division'];
        $district = $row['district'];
        $upazila = $row['upazila'];
        $bloodGroup = $row['blood_group'];
        $status = $row['status'];
        $type = $row['type'];
        $branch = $row['branch'];
    } else {
        echo "<script>alert('User not found.');</script>";
    }
    $stmt->close();
}


if (isset($_POST['update'])) {
    
    $name = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $cnumber = htmlspecialchars(trim($_POST['contactnumber']));
    $role = htmlspecialchars(trim($_POST['role']));
    $facebookId = htmlspecialchars(trim($_POST['facebookId']));
    $session = htmlspecialchars(trim($_POST['session']));
    $faculty = htmlspecialchars(trim($_POST['faculty']));
    $department = htmlspecialchars(trim($_POST['department']));
    $division = htmlspecialchars(trim($_POST['division']));
    $district = htmlspecialchars(trim($_POST['district']));
    $upazila = htmlspecialchars(trim($_POST['upazila']));
    $bloodGroup = htmlspecialchars(trim($_POST['bloodGroup']));
    $status = htmlspecialchars(trim($_POST['status']));
    $type = htmlspecialchars(trim($_POST['type']));
    $branch = htmlspecialchars(trim($_POST['types']));

    // Update SQL query
    $sql = "UPDATE users SET name=?, email=?, contact_number=?, role=?, facebook_id=?, session=?, faculty=?, department=?, division=?, district=?, upazila=?, blood_group=?, status=?, type=?, branch=? WHERE id=?";
    
    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssi", $name, $email, $cnumber, $role, $facebookId, $session, $faculty, $department, $division, $district, $upazila, $bloodGroup, $status, $type, $branch, $id);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "<script>alert('User information updated successfully.'); window.location.href='allmember.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit.css">
    <script>
        const districtsByType = {
            ward: [
                { bn: "বিজ্ঞান", banglish: "Science" },
                { bn: "বিবিএ", banglish: "BBA" },
                { bn: "আইন", banglish: "Law" },
                { bn: "আবাসিক", banglish: "Abashik" },
                { bn: "কলা", banglish: "Kola" },
                { bn: "সামাজিক বিজ্ঞান", banglish: "Samajik Biggan" },
                { bn: "চন্দ্রবিন্দু", banglish: "Chandrabindu" },
                { bn: "মডেল", banglish: "Model" },
                { bn: "আইডিয়াল", banglish: "Ideal" }
            ],
            bivak: [
                { bn: "সাংস্কৃতিক", banglish: "Sangskritik" },
                { bn: "ফোরাম", banglish: "Forum" },
                { bn: "ক্লাব", banglish: "Club" }
            ],
        };

        function updateDistrictts() {
            const divisionSelect = document.getElementById('type');
            const districtSelect = document.getElementById('types');
            const selectedDivisions = divisionSelect.value;

            
            while (districtSelect.options.length > 0) {
                districtSelect.remove(0);
            }

           
            if (selectedDivisions in districtsByType) {
                const districts = districtsByType[selectedDivisions];
                districts.forEach(({ bn, banglish }) => {
                    const option = document.createElement('option');
                    option.value = banglish.toLowerCase(); 
                    option.textContent = `${bn} (${banglish})`; 
                    districtSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Select a division first";
                districtSelect.appendChild(option);
            }
        }
    </script>
</head>
<body>
    <form action="" method="POST">
        <label>Name:</label>
        <input type="text" name="username" value="<?php echo $name; ?>" readonly><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br>

        <label>Contact Number:</label>
        <input type="text" name="contactnumber" value="<?php echo $cnumber; ?>" required><br>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="role" style="display: block; margin-bottom: 5px; font-weight: bold;">মান</label>
            <input type="text" name="role" value="<?php echo $role; ?>">
        </div>

        <label>Facebook ID:</label>
        <input type="text" name="facebookId" value="<?php echo $facebookId; ?>"><br>

        <label>Session:</label>
        <input type="text" name="session" value="<?php echo $session; ?>" readonly><br>

        <label>Faculty:</label>
        <input type="text" name="faculty" value="<?php echo $faculty; ?>" readonly><br>

        <label>Department:</label>
        <input type="text" name="department" value="<?php echo $department; ?>"><br>

        <label>Division:</label>
        <input type="text" name="division" value="<?php echo $division; ?>"><br>

        <label>District:</label>
        <input type="text" name="district" value="<?php echo $district; ?>"><br>

        <label>Upazila:</label>
        <input type="text" name="upazila" value="<?php echo $upazila; ?>"><br>

        <label>Blood Group:</label>
        <input type="text" name="bloodGroup" value="<?php echo $bloodGroup; ?>" readonly><br>


       <div class="form-group" style="margin-bottom: 15px;">
            <label for="status" style="display: block; margin-bottom: 5px; font-weight: bold;">Status</label>
            <select id="status" name="status" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd; box-shadow: none;">
                <option value="">মান নির্বাচন করুন</option>
                <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>সক্রিয় (active)</option>
                <option value="former" <?php echo ($status == 'former') ? 'selected' : ''; ?>>সাবেক (former)</option>
                
            </select>
        </div>



        <label>Type:</label>
        <select id="type" name="type" onchange="updateDistrictts();" required>
            <option value="">Choose Type</option>
            <option value="ward" <?php echo ($type == 'ward') ? 'selected' : ''; ?>>Ward</option>
            <option value="bivak" <?php echo ($type == 'bivak') ? 'selected' : ''; ?>>Bivak</option>
        </select><br>

        <label>Branch:</label>
        <select id="types" name="types" required>
            <option value="">Select Branch</option>
            <!-- Options will be populated based on Type selection -->
        </select><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
