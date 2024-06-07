<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('./../config/db_connect.php');

?>
<div class="main-container">
    <a href="viewMuscleGroups.php">
        <div class="container-child child1">
            <h2>Muscle Group</h2>
            <p>Total :
                <?php
                $sql = "SELECT COUNT(*) AS total FROM muscle_group";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo $row["total"];
                ?>
            </p>
        </div>
    </a>

    <a href="viewExercises.php">
        <div class="container-child child2">
            <h2>Exercise</h2>
            <p>Total :
                <?php
                $sql = "SELECT COUNT(*) AS total FROM exercise";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo $row["total"];
                ?>
            </p>
        </div>
    </a>

    <a href="manageUser.php">
        <div class="container-child child3">
            <h2>Users</h2>
            <p>Total :
                <?php
                $sql = "SELECT COUNT(*) AS total FROM user";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                echo $row["total"];
                ?>
            </p>
        </div>
    </a>

</div>