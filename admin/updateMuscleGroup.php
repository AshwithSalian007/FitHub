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



//fetch existing row and populate in input field
$sql = 'SELECT * FROM muscle_group WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $image = $row['photo'];
    $name = $row['name'];
    $description = $row['description'];
} else {
    echo "No record Found";
    echo '<br><a href="index.php">Go to Dashboard</a>';
    exit();
}



if (isset($_POST['update'])) {
    $isErrorExist = false;
    if ($_FILES['image']['tmp_name'] != "") {
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];
        if ($_FILES['image']['error'] === 0) {

            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_ext_lc = strtolower($file_ext);

            $new_file_name = uniqid('MUSCLE-', true) . '.' . $file_ext_lc;
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
        $sql = "UPDATE muscle_group SET name = ?, description = ?, photo = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $_POST['name'], $_POST['description'], $image, $_GET['id']);

        if (mysqli_stmt_execute($stmt)) {
            if (isset($_POST['referer'])) {
                $referer = $_POST['referer'];
                header("Location: $referer");
                exit();
            } else {
                header("Location: viewMuscleGroups.php");
                exit();
            }
        } else {
            echo "<script>alert('Error:  Not able to update record')</script>";
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
    <link rel="stylesheet" href="./css/updateMuscleGroup.css">
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
            <h1>Update Muscle Group</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <?php
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $referer_url = $_SERVER['HTTP_REFERER'];
                    echo "<input type='hidden' name='referer' value='$referer_url'>";
                }
                ?>
                <label for="muscleGroupName">Name</label>
                <input type="text" name="name" placeholder="Name" id="muscleGroupName" value="<?php echo $name ?>" required>
                <label for="muscleGroupDescription">Description</label>
                <textarea name="description" id="muscleGroupDescription" placeholder="Description" required><?php echo $description ?></textarea>
                <div class="form-item-admg">
                    <img id="imagePreview" src="./../uploads/<?php echo $image ?>">
                    <div>
                        <label class="file-label" for="MuscleGroupImage">Change Image</label>
                        <input type="file" id="MuscleGroupImage" title="Change" name="image" accept="image/*">
                    </div>
                </div>
                <button type="submit" name="update">Update</button>
            </form>
        </div>
        <!-- main content end   -->
    </div>

    <script>
        document.getElementById('MuscleGroupImage').addEventListener('change', function() {
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
                fileLabel.textContent = 'Change Image';
            }
        });
    </script>
</body>

</html>