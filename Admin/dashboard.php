<?php
   session_start();
   include "../includes/connect.php";
//    the counting of all users in DB excludes admins
   $users="select count(*) AS user_count from users where user_type !='Admin' ";
   $result=mysqli_query($conn,$users);
   $row=mysqli_fetch_assoc($result);
   //counting the total business 
   $businesses="select count(*) AS businesses_count  from businesses ";
   $business=mysqli_query($conn, $businesses);
   $b = mysqli_fetch_assoc($business)
   
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOBA Admin Dashboard</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        background: #f4f4f9;
    }

    .sidebar {
        width: 250px;
        background: #002a80;
        color: white;
        padding: 20px;
        height: 100vh;
        position: fixed;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        padding: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
    }

    .sidebar ul li:hover {
        background: #0044cc;
    }

    .main-content {
        margin-left: 270px;
        padding: 20px;
        width: calc(100% - 270px);
    }

    .cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
        justify-content: center;
    }

    .card {
        background: linear-gradient(135deg, #4f83ff, #002a80);
        padding: 15px;
        flex: 0 0 200px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        color: white;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card h3 {
        margin-bottom: 10px;
    }

    .table-container {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background: #002a80;
        color: white;
    }

    tr:nth-child(even) {
        background: #f4f4f9;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>KOBA Admin</h2>
        <ul>
            <li>🏠 Dashboard</li>
            <li>👥 Users</li>
            <li>📂 Categories</li>
            <li>🏘️ Districts</li>
            <li>🏢 Sectors</li>
            <li>🏢 Businesses</li>
            <li>📊 Reports</li>
            <li>⚙️ Settings</li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Dashboard</h1>
        <div class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $row['user_count']?></p>
            </div>
            <div class="card">
                <h3>Total Businesses</h3>
                <p><?php echo $b['businesses_count']?></p>
            </div>
            <div class="card">
                <h3>Total Categories</h3>
                <p>25</p>
            </div>
            <div class="card">
                <h3>Total Districts</h3>
                <p>25</p>
            </div>
            <div class="card">
                <h3>Total Sectors</h3>
                <p>25</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Recent Users</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>Active</td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>Inactive</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>