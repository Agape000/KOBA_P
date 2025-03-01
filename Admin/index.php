<?php
session_start();
include '../includes/connect.php'; // Database connection

if (isset($_POST['btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // selectin fro db g
    $result = mysqli_query($conn, "SELECT user_id, names, password  FROM users WHERE email = '$email' AND user_type = 'admin' LIMIT 1");

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password== $row['password']) {
            $_SESSION['admin_id'] = $row['user_id'];
            $_SESSION['admin_name'] = $row['names'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-container {
        background: #fff;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        width: 350px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 15px;
    }

    input,
    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    button {
        background: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .error {
        color: red;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="btn">Login</button>
        </form>
    </div>
</body>

</html>