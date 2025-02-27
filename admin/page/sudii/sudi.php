<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arafat Table Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sustyles.css">
    <style>
        /* Optional: Add some styling for the search input */
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h2 class="text-center mt-4">All Interest List</h2>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name, City, Mobile, or Branch">
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Father's Name</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Branch</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="dataTableBody">
                <?php
                include '../../../admin/config.php';
                // Fetch data from `arafat` table
                $sql = "SELECT id, name, father_name, mobile, city, branch, amount FROM arafat";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td><a href='sudiprofile.php?id=" . $row["id"] . "' class='text-primary'>" . $row["name"] . "</a></td>
                            <td>" . $row["father_name"] . "</td>
                            <td>" . $row["mobile"] . "</td>
                            <td>" . $row["city"] . "</td>
                            <td>" . $row["branch"] . "</td>
                            <td>TK. " . $row["amount"] . "</td>
                            <td>
                                <a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript function to filter the table based on the search input
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var filter = this.value.toLowerCase();
            var rows = document.querySelectorAll('#dataTableBody tr');

            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td');
                var found = false;

                // Check if any cell contains the search term
                for (var i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }

                // Show or hide the row based on the search term
                row.style.display = found ? '' : 'none';
            });
        });
    </script>
</body>
</html>
