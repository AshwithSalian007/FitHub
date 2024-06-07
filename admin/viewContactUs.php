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
    <link rel="stylesheet" href="./css/viewContactUs.css">
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
                <?php
                $sql = "SELECT * FROM contact_us ORDER BY seen ASC";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='" . ($row['seen'] == 0 ? "unseen" : "seen") . "' id='message-row-{$row['id']}'>";
                        echo "<td>$i</td>";
                        echo "<td>{$row['firstname']}</td>";
                        echo "<td>{$row['lastname']}</td>";
                        echo "<td>{$row['mobile']}</td>";
                        echo "<td class='email'>{$row['email']}</td>";
                        echo "<td class='message'>{$row['message']}</td>";
                        if ($row['seen'] == 0) {

                            echo "<td>
                            <button class='mark-read-btn' onclick='markAsRead(this, {$row['id']})'>Mark as Read</button>
                            </td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "</tr>";

                        $i++;
                    }
                } else {
                    echo "<tr><th colspan='7'>No Messages Yet</th></tr>";
                }



                ?>
            </table>
        </div>
        <!-- main content end   -->
    </div>

    <script>
        async function markAsRead(button, id) {
            try {
                const response = await fetch('functions/mark_as_read.php', {
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
                        document.getElementById('message-row-' + id).classList.remove('unseen');
                        document.getElementById('message-row-' + id).classList.add('seen');
                        button.disabled = true; // Optionally disable the button
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