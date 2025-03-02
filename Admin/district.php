<?php
session_start();
include "../includes/connect.php";
// initializing messages
$error_message = "";
$success_message = "";

// adding a new district
if (isset($_POST['btn_district'])) {
    $district_name = $_POST['district_name'];
    
    // Insert the district into the database
    $exists = "SELECT * FROM districts WHERE district_name = '$district_name'";
    $result_check = mysqli_query($conn, $exists);
    
    if (mysqli_num_rows($result_check) > 0) {
        $error_message = "⁉️ District already exists!";
        header("refresh:2");
    } else {
        $query = "INSERT INTO districts (district_name) VALUES ('$district_name')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $success_message = "✅ District inserted successfully!";
            header("refresh:2");
        } else {
            $error_message = "❌ Server error occurred!";
        }
    }
}

// Handle delete operation for district
if (isset($_GET['delete_district_id'])) {
    $district_id = $_GET['delete_district_id'];
    
    // Delete the district from the database
    $query = "DELETE FROM districts WHERE district_id = $district_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $success_message= "District deleted successfully";
        header("Location: district.php"); // Redirect after deletion
        exit();
    } else {
        $error_message= "Error: " . mysqli_error($conn);
    }
}

// Handle update operation for district
if (isset($_GET['edit_district_id'])) {
    $district_id = $_GET['edit_district_id'];
    
    // Fetch the district to be updated
    $query = "SELECT * FROM districts WHERE district_id = $district_id";
    $result = mysqli_query($conn, $query);
    $district = mysqli_fetch_assoc($result);
}

// Handle form submission for updating a district
if (isset($_POST['update_district_btn'])) {
    $district_id = $_POST['district_id'];
    $district_name = $_POST['district_name'];
    
    // Update the district in the database
    $query = "UPDATE districts SET district_name = '$district_name' WHERE district_id = $district_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $success_message= "District updated successfully!";
        header("Location: district.php"); // Redirect after update
        exit();
    } else {
        $error_message= "Error: " . mysqli_error($conn);
    }
}

// Fetch all districts
$query = "SELECT * FROM districts ORDER BY district_name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Districts</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    /* Styling for the page */
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
    }

    .content {
        flex: 1;
        padding: 20px;
        margin-left: 270px;
    }

    .container {
        width: 100%;
        max-width: 800px;
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

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .submit-btn {
        background-color: #002a80;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #003cb3;
    }

    .category-list {
        margin-top: 30px;
    }

    .category-list ul {
        list-style-type: none;
        padding-left: 0;
    }

    .category-list li {
        background-color: #f4f4f9;
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-list li:hover {
        background-color: #e1e1e1;
    }

    .category-actions {
        display: flex;
        gap: 10px;
    }

    .category-actions a {
        text-decoration: none;
        color: #002a80;
    }

    .category-actions a:hover {
        color: #003cb3;
    }

    /* Modal styles */
    .modal,
    .delete-confirmation {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content,
    .delete-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Delete confirmation button styling */
    .delete-btn {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background-color: darkred;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include "../includes/sidebar.php"; ?>
        <div class="content">
            <div class="container">
                <!-- Add District Form -->
                <h2>Add District</h2>
                <!-- messages -->
                <?php if ($error_message) { ?>
                <div class="message error-message">
                    <?php echo $error_message; ?>
                </div>
                <?php } ?>
                <?php if ($success_message) { ?>
                <div class="message success-message">
                    <?php echo $success_message; ?>
                </div>
                <?php } ?>
                <form action="district.php" method="POST">
                    <div class="form-group">
                        <label for="district_name">District Name:</label>
                        <input type="text" id="district_name" name="district_name" placeholder="Enter district name"
                            required>
                    </div>
                    <button type="submit" name="btn_district" class="submit-btn">Add District</button>
                </form>

                <!-- View Districts -->
                <h2>View Districts</h2>
                <div class="category-list">
                    <?php
                    // Check if districts exist and display them
                    if (mysqli_num_rows($result) > 0) {
                        echo "<ul>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li>" .$row['district_name'] . 
                                 "<div class='category-actions'>
                                     <a href='javascript:void(0)' onclick='openEditModal(" . $row['district_id'] . ", \"" . addslashes($row['district_name']) . "\")'><i class='fas fa-edit'></i> Edit</a>
                                     <a href='javascript:void(0)' onclick='openDeleteModal(" . $row['district_id'] . ")'><i class='fas fa-trash'></i> Delete</a>
                                  </div>
                                  </li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No districts available.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing district -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit District</h2>
            <form action="district.php" method="POST">
                <div class="form-group">
                    <label for="district_name">District Name:</label>
                    <input type="text" id="edit_district_name" name="district_name" required>
                    <input type="hidden" id="edit_district_id" name="district_id">
                </div>
                <button type="submit" name="update_district_btn" class="submit-btn">Update District</button>
            </form>
        </div>
    </div>

    <!-- Modal for delete confirmation -->
    <div id="deleteModal" class="delete-confirmation">
        <div class="delete-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h3>Are you sure you want to delete this district?</h3>
            <button id="confirmDeleteBtn" class="delete-btn">Yes, Delete</button>
            <button class="submit-btn" onclick="closeDeleteModal()">Cancel</button>
        </div>
    </div>

    <script>
    // Open edit modal
    function openEditModal(districtId, districtName) {
        document.getElementById('editModal').style.display = "block";
        document.getElementById('edit_district_name').value = districtName;
        document.getElementById('edit_district_id').value = districtId;
    }

    // Close edit modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = "none";
    }

    // Open delete modal
    function openDeleteModal(districtId) {
        document.getElementById('deleteModal').style.display = "block";
        document.getElementById('confirmDeleteBtn').onclick = function() {
            window.location.href = "district.php?delete_district_id=" + districtId;
        };
    }

    // Close delete modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = "none";
    }
    </script>
</body>

</html>