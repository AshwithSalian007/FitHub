<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit;
}
$name = "";
$dob = "";
$email = "";
$mobile = "";
$password = "";

if (isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeatPassword'])) {

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    if ($_POST['password'] == $_POST['repeatPassword']) {
        $password = $_POST['password'];

        include('config/db_connect.php');



        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists in database
        if ($result->num_rows == 1) {
            $emailError = "Email is already being used.";
        } else {
            $sql = "INSERT INTO user (name, email, password, mobile_no, dob) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $password, $mobile, $dob);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['user_name'] = $name;
                // Redirect user to dashboard or another page
                header("Location: index.php#exercise");
                exit;
            } else {
                echo "<script>alert('Error:  Not able Register Currently')</script>";
            }
        }
    } else {
        $passwordError = "Password does not match";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <div class="image-section">
            <img src="images/login.jpeg" alt="Sign Up Image">
        </div>
        <div class="form-section">
            <h2>Sign up</h2>
            <form action="" method="post">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" name="name" placeholder="Name..." required value="<?= $name ?>">

                <label for="mobile-no">Mobile Number</label>
                <input type="text" id="mobile-no" name="mobile" placeholder="### ### ####" required value="<?= $mobile ?>">

                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" style="color: #555;" required value="<?= $dob ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email address..." required value="<?= $email ?>">
                <p class="error-msg">
                    <?php if (isset($emailError)) {
                        echo $emailError;
                    } ?>
                </p>

                <!-- <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username..."> -->

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required value="<?= $password ?>">

                <label for="repeat-password">Repeat Password</label>
                <input type="password" id="repeat-password" name="repeatPassword" placeholder="Repeat Password" required>
                <p class="error-msg">
                    <?php if (isset($passwordError)) {
                        echo $passwordError;
                    } ?>
                </p>

                <!-- <div class="checkbox-container">
                    <input type="checkbox" id="terms" name="terms">
                    <label for="terms">I agree to the Terms of User</label>
                </div> -->

                <button name="submit" type="submit">Sign up</button>
                <p class="endredirect-txt">Already have a account? <a href="login.php" class="sign-in">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>