<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('./../config/db_connect.php');
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $file_name = $_FILES['image']['name'];
    $file_temp = $_FILES['image']['tmp_name'];
    $file_error = $_FILES['image']['error'];
    $folder = '../uploads/';

    if ($file_error === 0) {
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_ext_lc = strtolower($file_ext);

        $new_file_name = uniqid('MUSCLE-', true) . '.' . $file_ext_lc;
        $file_upload_path = $folder . $new_file_name;

        if (move_uploaded_file($file_temp, $file_upload_path)) {
            $sql = "INSERT INTO muscle_group (name, description, photo) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $name, $description, $new_file_name);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Added Muscle Group Successfully')</script>";
            } else {
                echo "<script>alert('Error:  Not able to add Muscle Group')</script>";
            }
        } else {
            echo "<script>alert('Failed to add. Unknown error occurred!')</script>";
        }
    } else {
        echo "<script>alert('Failed to add. Unknown error occurred!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="./css/adminAllStyle.css">
    <link rel="stylesheet" href="./css/addMuscleGroup.css">
</head>

<body>
    <!-- side section start  -->
    <?php include('./include/sidebar.php') ?>
    <!-- side section end  -->

    <!-- header start -->
    <?php include('./include/header.php') ?>
    <!-- header end  -->

    <div class="ad-main-content-container">
        <!-- main content start  -->
        <div class="main-container">
            <h1>Add Muscle Group</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="muscleGroupName">Name</label>
                <input type="text" name="name" placeholder="Name" id="muscleGroupName" required>
                <label for="muscleGroupDescription">Description</label>
                <textarea name="description" id="muscleGroupDescription" maxlength="250" placeholder="Description" required></textarea>
                <div class="form-item-admg">
                    <label for="MuscleGroupImage">Image:</label>
                    <input type="file" id="MuscleGroupImage" name="image" accept="image/*" required>
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <!-- main content end   -->
    </div>

</body>

</html>