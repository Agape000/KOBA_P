<?php
session_start();
include "../includes/connect.php";

// Fetch all users except Admins
$query = "SELECT user_id, names, email, phone, user_type FROM users WHERE user_type != 'Admin' ORDER BY names ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #f4f4f9;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background: #002a80;
        color: white;
        padding: 20px;
        min-height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
    }

    .content {
        flex: 1;
        padding: 20px;
        margin-left: 270px;
        /* Adjust based on sidebar width */
    }

    .container {
        width: 100%;
        max-width: 1000px;
        /* Prevent table overflow */
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    h2 {
        text-align: center;
        color: #002a80;
    }

    .search-box {
        width: 40%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background: #002a80;
        color: white;
    }

    tr:nth-child(even) {
        background: #f4f4f9;
    }

    .no-results {
        text-align: center;
        font-style: italic;
        color: red;
        display: none;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include "../includes/sidebar.php"; ?>
        <div class="content">
            <div class="container">
                <h2>Users List</h2>
                <input type="text" id="searchInput" class="search-box"
                    placeholder="🔍 Search users by name, email, or phone...">

                <table id="usersTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . $row['names'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['user_type'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <p class="no-results" id="noResults">No users found</p>
            </div>
        </div>
    </div>

    <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#usersTable tbody tr");
        let noResults = document.getElementById("noResults");
        let visible = 0;

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = "";
                visible++;
            } else {
                row.style.display = "none";
            }
        });

        noResults.style.display = visible === 0 ? "block" : "none";
    });
    </script>
</body>

</html>