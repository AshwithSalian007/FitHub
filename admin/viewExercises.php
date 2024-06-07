<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include('./../config/db_connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="./css/adminAllStyle.css">
    <link rel="stylesheet" href="./css/viewExercise.css">
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
            <div class="exercise-navigation-container">

            </div>
            <div class="exercise-list-container">
                <table>
                    <tr>
                        <th>Sl.no</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Muscle Group</th>
                        <th>Description</th>
                        <th>Routine</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $sql = "SELECT ex.*, lvl.name as level, msl.name as muscle FROM exercise AS ex 
                    JOIN level AS lvl ON ex.level_id = lvl.id
                    JOIN muscle_group as msl ON ex.muscle_group_id = msl.id 
                    ORDER BY ex.level_id ASC, ex.muscle_group_id ASC;";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<tr><th class='not-found-msg' colspan='8'>No Record Found</th></tr>";
                    }
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['level']}</td>";
                        echo "<td>{$row['muscle']}</td>";
                        echo "<td class='description'><p>{$row['description']}</p></td>";
                        echo "<td>
                            " . ($row['typical_set'] > 0 ? "<span>SET: {$row['typical_set']}</span><br>" : "") . "
                            " . ($row['typical_rep'] > 0 ? "<span>REP: {$row['typical_rep']}</span><br>" : "") . "
                            " . ($row['typical_duration_sec'] > 0 ? "<span>DURATION: {$row['typical_duration_sec']}</span><br>" : "") . "
                        </td>";
                        echo "<td><img src='../uploads/{$row['photo']}' ></td>";
                        echo "<td><a class='action-btn update' href='updateExercise.php?id={$row['id']}'>UPDATE</a> <a class='action-btn delete' href='deleteExercise.php?id={$row['id']}' onclick='return confirmDelete(\"{$row['name']}\")'>DELETE</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>

                </table>
            </div>

        </div>
        <!-- main content end   -->
    </div>

    <script>
        function confirmDelete(name) {
            let confirm = window.confirm(`Are you sure you want to delete ${name} Exercise?`);
            if (confirm) {
                return true;
            } else {
                return false;
            }
        }
    </script>

</body>

</html>