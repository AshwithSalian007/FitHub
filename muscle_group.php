<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['level'])) {
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
            <h2>Choose a Muscle Group</h2>
            <p class="title-p">Select the muscle group you want to focus on to discover tailored exercises that will help you achieve your fitness goals. Whether you're targeting your chest, back, legs, or any other muscle group, we've got you covered with a variety of effective workouts designed to strengthen and sculpt your body.</p>
            <?php
            $sql = "SELECT * FROM muscle_group";

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
                                        <p><?= $row['description'] ?></p>
                                    </div>
                                    <!-- <p>Gym and Cardio</p>
                                        <p>Service Locker Rooms</p> -->
                                    <a href="exercise.php?level=<?php echo $_GET['level'] ?>&muscle=<?php echo $row['id'] ?>" class="btn">Exercise</a>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            <?php
            } else {
                echo "<h1 style='text-align: center;'>No Muscle Group Found</h1>";
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