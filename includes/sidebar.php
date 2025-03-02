<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

    /* Sidebar Links */
    .sidebar ul li a {
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        border-radius: 5px;
        width: 100%;
    }

    .sidebar ul li a:hover {
        background: #0044cc;
        width: 50%;
    }

    .sidebar ul li {
        padding: 0;
    }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>KOBA Admin</h2>
        <ul>
            <li><a href="../Admin/dashboard.php">🏠 Dashboard</a></li>
            <li><a href="users.php">👥 Users</a></li>
            <li><a href="../Admin/category.php">📂 Categories</a></li>
            <li><a href="../Admin/district.php">🏘️ Districts</a></li>
            <li><a href="#">🏢 Sectors</a></li>
            <li><a href="#">🏢 Businesses</a></li>
            <li><a href="#">📊 Reports</a></li>
            <li><a href="#">⚙️ Settings</a></li>
        </ul>
    </div>
</body>

</html>