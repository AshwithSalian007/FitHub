<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include('./../config/db_connect.php');

$results_per_page = 10;
// Determine current page number
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
// Calculate SQL OFFSET
$offset = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM muscle_group LIMIT $offset, $results_per_page";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$sql = "SELECT COUNT(*) AS total FROM muscle_group";

$pageResult = $conn->query($sql);
$totalRow = $pageResult->fetch_assoc();
$total_pages = ceil($totalRow["total"] / $results_per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="./css/adminAllStyle.css">
    <link rel="stylesheet" href="./css/viewMuscleGroup.css">
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
            <div class="page-navigation-container">
                <div class="page-arrow-nav-bx">
                    <?php
                    if ($page > 1) {
                        echo "<a href='?page=" . ($page - 1) . "'>&lt;</a> ";
                    } else {
                        echo "<a class='disabled'>&lt;</a> ";
                    }
                    if ($page < $total_pages) {
                        echo "<a href='?page=" . ($page + 1) . "'>&gt;</a> ";
                    } else {
                        echo "<a class='disabled'>&gt;</a> ";
                    }
                    ?>
                </div>
            </div>
            <div class="muscle-group-list-container">
                <table>
                    <tr>
                        <th>Sl.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . ($offset + $i) . "</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td><img class='muscleimg' src='./../uploads/{$row['photo']}'></td>";
                            echo "<td><div class='actionBtnContainer'><a class='updateMuscleBtn' href='updateMuscleGroup.php?id={$row['id']}'>Update</a><a class='deleteMuscleBtn' href='deleteMuscleGroup.php?id={$row['id']}' onclick='return confirmDelete(\"{$row['name']}\")'>Delete</a></div></td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr>";
                        echo "<td style='color: red;' colspan='5'>No Muscle Group Found</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

        </div>
        <!-- main content end   -->
    </div>

    <script>
        function confirmDelete(name) {
            let confirm = window.confirm(`Are you sure you want to delete ${name} Muscle Group?`);
            if (confirm) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>