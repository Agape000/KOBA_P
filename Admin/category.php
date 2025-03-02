<?php
session_start();
include "../includes/connect.php";
// initializing messages
$error_message="";
$success_message="";
// adding a new category
if (isset($_POST['btn'])) {
    $category_name = $_POST['category_name'];
    
    // Insert the category into the database
    $exists=mysqli_query($conn, "select * from categories where category_name='$category_name'");
    
    if(mysqli_num_rows($exists)>0){
        $error_message= "⁉️category Arleady exists";
        header("refresh:2");
        
    }
    else{

        $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
        $result = mysqli_query($conn, $query);
        if ($result){
            $success_message =" ✅inserted successfully";
            header("refresh:2");
        }
    else{
        $error_message=" server error occured ";
    }
        
    }
    
    
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $category_id = $_GET['delete_id'];
    
    // Delete the category from the database
    $query = "DELETE FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $success_message= "Category deleted successfully";
    } else {
        $error_message="Error: " . mysqli_error($conn);
    }
}

// Handle update operation
if (isset($_GET['edit_id'])) {
    $category_id = $_GET['edit_id'];
    
    // Fetch the category to be updated
    $query = "SELECT * FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);
}

// Handle form submission for updating a category
if (isset($_POST['update_btn'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    
    // Update the category in the database
    $query = "UPDATE categories SET category_name = '$category_name' WHERE category_id = $category_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $success_message= "Category updated successfully";
    } else {
        $error_message= "Error: " . mysqli_error($conn);
    }
}

// Fetch all categories
$query = "SELECT * FROM categories ORDER BY category_name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>

    <style>
    /* General styles */
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
        margin-top: 30px;
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

    /* Modal Styles */
    .modal,
    .delete-confirmation {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content,
    .delete-content {
        background-color: #fefefe;
        margin: auto;
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

    .confirm-btn {
        background-color: #d9534f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .confirm-btn:hover {
        background-color: #c9302c;
    }

    .cancel-btn {
        background-color: #5bc0de;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .cancel-btn:hover {
        background-color: #31b0d5;
    }

    .message {
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .error-message {
        background-color: #f8d7da;
        color: red;
        border: 1px solid #f5c6cb;
    }


    .success-message {
        background-color: #d4edda;
        color: green;
        border: 1px solid #c3e6cb;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include "../includes/sidebar.php"; ?>
        <div class="content">
            <div class="container">
                <!-- Add Category Form -->
                <h2>Add Category</h2>
                <!-- messages -->
                <!-- error message -->
                <?php  if($error_message){?>
                <div class="message error-message">
                    <?php echo $error_message; ?>
                </div>
                <?php }?>
                <!-- sucess message -->
                <?php  if($success_message){?>
                <div class="message success-message">
                    <?php echo $success_message; ?>
                </div>
                <?php }?>
                <form action="category.php" method="POST">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" id="category_name" name="category_name" placeholder="Enter category name"
                            required>
                    </div>
                    <button type="submit" name="btn" class="submit-btn">Add Category</button>
                </form>

                <!-- View Categories -->
                <h2>View Categories</h2>
                <div class="category-list">
                    <?php
                    // Check if categories exist and display them
                    if (mysqli_num_rows($result) > 0) {
                        echo "<ul>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li>" . $row['category_name'] . 
                                 "<div class='category-actions'>
                                     <a href='javascript:void(0)' onclick='openEditModal(" . $row['category_id'] . ", \"" . addslashes($row['category_name']) . "\")'><i class='fas fa-edit'></i> Edit</a>
                                     <a href='javascript:void(0)' onclick='openDeleteModal(" . $row['category_id'] . ")'><i class='fas fa-trash'></i> Delete</a>
                                  </div>
                                  </li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No categories available.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing category -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Category</h2>
            <form action="category.php" method="POST">
                <div class="form-group">
                    <label for="category_name">Category Name:</label>
                    <input type="text" id="edit_category_name" name="category_name" required>
                    <input type="hidden" id="edit_category_id" name="category_id">
                </div>
                <button type="submit" name="update_btn" class="submit-btn">Update Category</button>
            </form>
        </div>
    </div>

    <!-- Modal for delete confirmation -->
    <div id="deleteModal" class="delete-confirmation">
        <div class="delete-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h3>Are you sure you want to delete this category?</h3>
            <button id="confirmDeleteBtn" class="confirm-btn">Yes, Delete</button>
            <button class="cancel-btn" onclick="closeDeleteModal()">Cancel</button>
        </div>
    </div>

    <script>
    // Open the edit modal and fill the inputs with category data
    function openEditModal(categoryId, categoryName) {
        document.getElementById('edit_category_id').value = categoryId;
        document.getElementById('edit_category_name').value = categoryName;
        document.getElementById('editModal').style.display = "block";
    }

    // Close the edit modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = "none";
    }

    // Open the delete confirmation modal
    function openDeleteModal(categoryId) {
        document.getElementById('deleteModal').style.display = "block";
        document.getElementById('confirmDeleteBtn').onclick = function() {
            window.location.href = "category.php?delete_id=" + categoryId;
        };
    }

    // Close the delete confirmation modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = "none";
    }

    // Close modal if clicked outside of modal content
    window.onclick = function(event) {
        if (event.target === document.getElementById('editModal')) {
            closeEditModal();
        } else if (event.target === document.getElementById('deleteModal')) {
            closeDeleteModal();
        }
    }
    </script>
</body>

</html>