<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

include('./../config/db_connect.php');

$sql = "SELECT ex.*, lvl.name as level, msl.name as muscle FROM exercise AS ex 
                    JOIN level AS lvl ON ex.level_id = lvl.id
                    JOIN muscle_group as msl ON ex.muscle_group_id = msl.id 
                    WHERE ex.id = ?;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $description = $row['description'];
    $level_id = $row['level_id'];
    $muscle_group_id = $row['muscle_group_id'];
    $image = $row['photo'];
    $typical_set = $row['typical_set'];
    $typical_rep = $row['typical_rep'];
    $typical_duration_sec = $row['typical_duration_sec'];
    $level_name = $row['level'];
    $muscle_name = $row['muscle'];
} else {
    echo "No record Found";
    echo '<br><a href="index.php">Go to Dashboard</a>';
    exit();
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $level_id = $_POST['level'];
    $muscle_group_id = $_POST['muscle_group'];
    $typical_set = $_POST['set'];
    $typical_rep = $_POST['rep'];
    $typical_duration_sec = $_POST['duration'];

    $isErrorExist = false;
    if ($_FILES['image']['tmp_name'] != "") {
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];
        if ($_FILES['image']['error'] === 0) {

            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_ext_lc = strtolower($file_ext);

            $new_file_name = uniqid("L{$level_id}-M{$muscle_group_id}-EXERCISE-", true) . '.' . $file_ext_lc;
            $file_upload_path = '../uploads/' . $new_file_name;

            if (move_uploaded_file($file_temp, $file_upload_path)) {
                if (file_exists('../uploads/' . $image)) {
                    unlink('../uploads/' . $image);
                }
                $image = $new_file_name;
            } else {
                $isErrorExist = true;
                echo "<script>alert('Failed to update. Unkown error occurred!')</script>";
            }
        } else {
            $isErrorExist = true;
            echo "<script>alert('Failed to update. Unkown error occurred while Image update!')</script>";
        }
    }










    if (!$isErrorExist) {
        $sql = "UPDATE exercise SET name = ?, description = ?, level_id = ?, muscle_group_id = ?, photo = ?, typical_set = ?, typical_rep = ?, typical_duration_sec = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiisiiii", $name, $description, $level_id, $muscle_group_id, $image, $typical_set, $typical_rep, $typical_duration_sec, $_GET['id']);

        if (mysqli_stmt_execute($stmt)) {
            if (isset($_POST['referer'])) {
                $referer = $_POST['referer'];
                header("Location: $referer");
                exit();
            } else {
                header("Location: viewExercises.php");
                exit();
            }
        } else {
            echo "<script>alert('Error:  Not able to Update Exercise')</script>";
        }
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
            <h1>Update Exercise</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <?php
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $referer_url = $_SERVER['HTTP_REFERER'];
                    echo "<input type='hidden' name='referer' value='$referer_url'>";
                }
                ?>
                <label for="exerciseName">Name</label>
                <input type="text" id="exerciseName" name="name" placeholder="Name" required value="<?= $name ?>">
                <label for="exerciseDescription">Description</label>
                <textarea name="description" id="exerciseDescription" rows="10" placeholder="Description" required><?= $description ?></textarea>
                <label for="exerciseLevel">Level</label>
                <select name="level" id="exerciseLevel" required>
                    <option value="<?= $level_id ?>"><?= $level_name ?></option>
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
                    <option value="<?= $muscle_group_id ?>"><?= $muscle_name ?></option>
                    <?php
                    $sql = "SELECT * FROM muscle_group";
                    $muscleResult = $conn->query($sql);
                    while ($muscleRow = $muscleResult->fetch_assoc()) {
                        echo "<option value='{$muscleRow['id']}'>{$muscleRow['name']}</option>";
                    }
                    ?>
                </select>
                <div>
                    <img id="imagePreview" style="width: 150px; box-shadow: 0 0 5px #00000088; margin-top: 15px;" src="./../uploads/<?= $image ?>" alt="">
                </div>
                <label class="file-label" style="background-color: #555; color: #fff; width: max-content; padding: 5px 15px;" for="exerciseImage">Change</label>
                <input style="display: none;" type="file" id="exerciseImage" name="image" accept="image/*">
                <div class="set-rep-dur-input-container">
                    <label for="exerciseSet">Set</label>
                    <input type="number" name="set" id="exerciseSet" min="0" placeholder="Set (optional)" value="<?= ($typical_set > 0 ? $typical_set : "") ?>">
                    <label for="exerciseRep">Rep</label>
                    <input type="number" name="rep" id="exerciseRep" min="0" placeholder="Rep (optional)" value="<?= ($typical_rep > 0 ? $typical_rep : "") ?>">
                    <label for="exerciseDuration">Duration</label>
                    <input type="number" name="duration" id="exerciseDuration" min="0" placeholder="Seconds (optional)" value="<?= ($typical_duration_sec > 0 ? $typical_duration_sec : "") ?>">
                </div>
                <button type="submit" name="update">Update</button>
            </form>
        </div>
        <!-- main content end   -->
    </div>


    <script>
        document.getElementById('exerciseImage').addEventListener('change', function() {
            var file = this.files[0];
            var fileLabel = document.querySelector('.file-label');
            var imagePreview = document.getElementById('imagePreview');

            if (file) {
                fileLabel.textContent = file.name;

                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = "./../uploads/<?php echo $image ?>";
                fileLabel.textContent = 'Change';
            }
        });
    </script>
</body>

</html>