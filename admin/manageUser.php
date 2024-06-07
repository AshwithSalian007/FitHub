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
    <link rel="stylesheet" href="./css/manageUser.css">
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
            <table>
                <tr>
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php
                $sql = "SELECT * FROM user ORDER BY id DESC";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='user-row-{$row['id']}'>";
                        echo "<td>$i</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['dob']}</td>";
                        echo "<td>{$row['mobile_no']}</td>";
                        echo "<td class='email'>{$row['email']}</td>";
                        echo "<td><button onclick='deleteUser({$row['id']})'>Delete</button></td>";
                        echo "</tr>";

                        $i++;
                    }
                } else {
                    echo "<tr><th colspan='6'>No Messages Yet</th></tr>";
                }



                ?>
            </table>
        </div>
        <!-- main content end   -->
    </div>

    <script>
        async function deleteUser(id) {
            let confirm = window.confirm(`Are you sure you want to delete?`);
            if (!confirm) {
                return;
            }
            try {
                const response = await fetch('functions/delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id: id
                    })
                });

                if (response.ok) {
                    const result = await response.text();
                    if (result === 'success') {
                        document.getElementById('user-row-' + id).style.display = "none";
                    } else {
                        console.error('Error:', result);
                    }
                } else {
                    console.error('HTTP error:', response.status);
                }
            } catch (error) {
                console.error('Fetch error:', error);
            }
        }
    </script>
</body>

</html>