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
    $level = $_POST['level'];
    $muscle_group = $_POST['muscle_group'];
    $set_count = $_POST['set'];
    $rep_count = $_POST['rep'];
    $duration = $_POST['duration'];

    $file_name = $_FILES['image']['name'];
    $file_temp = $_FILES['image']['tmp_name'];
    $file_error = $_FILES['image']['error'];
    $folder = '../uploads/';

    if ($file_error === 0) {
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_ext_lc = strtolower($file_ext);

        $new_file_name = uniqid("L{$level}-M{$muscle_group}-EXERCISE-", true) . '.' . $file_ext_lc;
        $file_upload_path = $folder . $new_file_name;

        if (move_uploaded_file($file_temp, $file_upload_path)) {
            $sql = "INSERT INTO exercise (name, description, level_id, muscle_group_id, photo, typical_set, typical_rep, typical_duration_sec) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssiisiii", $name, $description, $level, $muscle_group, $new_file_name, $set_count, $rep_count, $duration);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Added Exercise Successfully')</script>";
            } else {
                echo "<script>alert('Error:  Not able to add Exercise')</script>";
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
    <link rel="stylesheet" href="./css/addExercise.css">
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
            <h1>Add Exercise</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="exerciseName">Name</label>
                <input type="text" id="exerciseName" name="name" placeholder="Name" required>
                <label for="exerciseDescription">Description</label>
                <textarea name="description" id="exerciseDescription" rows="10" placeholder="Description" required></textarea>
                <label for="exerciseLevel">Level</label>
                <select name="level" id="exerciseLevel" required>
                    <option value="">Select</option>
                    <?php
                    $sql = "SELECT * FROM level";
                    $levelResult = $conn->query($sql);
                    while ($levelRow = $levelResult->fetch_assoc()) {
                        echo "<option value='{$levelRow['id']}'>{$levelRow['name']}</option>";
                    }
                    ?>
                </select>
                <label for="exerciseMuscleGroup">Muscle Group</label>
                <select name="muscle_group" id="exerciseMuscleGroup" required>
                    <option value="">Select</option>
                    <?php
                    $sql = "SELECT * FROM muscle_group";
                    $muscleResult = $conn->query($sql);
                    while ($muscleRow = $muscleResult->fetch_assoc()) {
                        echo "<option value='{$muscleRow['id']}'>{$muscleRow['name']}</option>";
                    }
                    ?>
                </select>
                <label for="exerciseImage">Image</label>
                <input type="file" id="exerciseImage" name="image" accept="image/*" required>
                <div class="set-rep-dur-input-container">
                    <label for="exerciseSet">Set</label>
                    <input type="number" name="set" id="exerciseSet" min="0" placeholder="Set (optional)">
                    <label for="exerciseRep">Rep</label>
                    <input type="number" name="rep" id="exerciseRep" min="0" placeholder="Rep (optional)">
                    <label for="exerciseDuration">Duration</label>
                    <input type="number" name="duration" id="exerciseDuration" min="0" placeholder="Seconds (optional)">
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <!-- main content end   -->
    </div>

</body>

</html>