<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['exercise'])) {
    header('location: index.php');
    exit;
}
include('./config/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muscle Group</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/viewExercise.css">
</head>

<body>

    <!-- Start Header  -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">Fitness <span>Club</span></a>
            </div>
        </div>
    </header>
    <!-- End Header  -->

    <section class="price-package" id="price">
        <div class="container">
            <?php
            $id = $_GET['exercise'];
            $sql = "SELECT * FROM exercise WHERE id='$id'";

            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <h1 class="exercise-heading"><?= $row['name'] ?></h1>
                    <div class="content-container">
                        <img src="uploads/<?= $row['photo'] ?>" alt="">
                        <h3 class="routing-content-container">
                            <?php
                            if ($row['typical_set'] > 0) {
                                echo "<span>SET: {$row['typical_set']}</span>";
                            }
                            if ($row['typical_rep'] > 0) {
                                echo "<span>REP: {$row['typical_rep']}</span>";
                            }
                            if ($row['typical_duration_sec'] > 0) {
                                echo "<span>DURATION: {$row['typical_duration_sec']} second" . ($row['typical_duration_sec'] > 1 ? "s" : "") . "</span>";
                            }
                            ?>
                        </h3>
                        <p class="exercise-description">
                            <?= nl2br($row['description']) ?>
                        </p>
                    </div>





                <?php
                }
                ?>


            <?php
            } else {
                echo "<h1 style='text-align: center;'>No Exercise Found</h1>";
            }
            ?>
        </div>
    </section>
</body>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let boxes = document.querySelectorAll('.muscleGroupBox');
        let maxHeight = 0;

        // Calculate the maximum height
        boxes.forEach(box => {
            let boxHeight = box.offsetHeight;
            if (boxHeight > maxHeight) {
                maxHeight = boxHeight;
            }
        });

        // Apply the maximum height to all boxes
        boxes.forEach(box => {
            box.style.height = maxHeight + 'px';
        });
    });
</script>

</html>