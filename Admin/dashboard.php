<?php
session_start();
include "../includes/connect.php";

// Optimized query to get multiple counts in one call
$query = "
    SELECT 
        (SELECT COUNT(*) FROM users WHERE user_type != 'Admin') AS user_count,
        (SELECT COUNT(*) FROM businesses) AS businesses_count,
        (SELECT COUNT(*) FROM categories) AS categories_count,
        (SELECT COUNT(*) FROM districts) AS districts_count,
        (SELECT COUNT(*) FROM sectors) AS sectors_count
";

$result = mysqli_query($conn, $query);
$counts = mysqli_fetch_assoc($result);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOBA Admin Dashboard</title>
    <style>
    body {
        font-family: Lato;
        margin: 0;
        padding: 0;
        display: flex;
        background: #f4f4f9;
    }

    h1 {
        margin-left: 30px;
        font-family: Lato;
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
        margin-top: 60px;
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
    </style>
</head>

<body>

    <?php  include "../includes/sidebar.php" ?>
    <div class="main-content">
        <h1>Welcome to the Admin Dashboard</h1>
        <div class="cards">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $counts['user_count']?></p>
            </div>
            <div class="card">
                <h3>Total Businesses</h3>
                <p><?php echo $counts['businesses_count']?></p>
            </div>
            <div class="card">
                <h3>Total Categories</h3>
                <p><?php echo $counts['categories_count']?></p>
            </div>
            <div class="card">
                <h3>Total Districts</h3>
                <p><?php echo $counts['districts_count']?></p>
            </div>
            <div class="card">
                <h3>Total Sectors</h3>
                <p><?php echo $counts['sectors_count']?></p>
            </div>
        </div>


    </div>
</body>

</html>