<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}
if (!(isset($_GET['level']) && isset($_GET['muscle']))) {
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
    <title>Exercise</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
            <h2>Execute this exercise to reach your fitness goals.</h2>
            <p class="title-p">This exercise targets your core muscles and helps improve your balance. Perform this exercise to stay in shape.</p>
            <?php
            $level = $_GET['level'];
            $muscle = $_GET['muscle'];
            $sql = "SELECT * FROM exercise WHERE level_id = '$level' AND muscle_group_id = '$muscle'";

            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
            ?>
                <div class="content">


                    <?php
                    while ($row = $result->fetch_assoc()) { ?>


                        <div class="box wow bounceInUp muscleGroupBox">
                            <div class="inner">
                                <div class="price-tag">
                                    <?= $row['name'] ?>
                                </div>
                                <div class="img">
                                    <img src="uploads/<?= $row['photo'] ?>" alt="price" />
                                </div>
                                <div class="text">
                                    <div>
                                        <h3><?= $row['name'] ?></h3>
                                        <p class="routin-container">
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
                                        </p>
                                    </div>
                                    <!-- <p>Gym and Cardio</p>
                                        <p>Service Locker Rooms</p> -->
                                    <a href="viewExercise.php?exercise=<?php echo $row['id'] ?>" class="btn">VIEW</a>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </div>
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