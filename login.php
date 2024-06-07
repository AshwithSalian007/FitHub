<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit;
}
$email = "";
$password = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
    include('config/db_connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user from database
    $sql = "SELECT * FROM user WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists in database
    if ($result->num_rows == 1) {
        // User exists, set session variables
        $row = $result->fetch_assoc();
        $_SESSION['user_name'] = $row['name'];
        // Redirect user to dashboard or another page
        header("Location: index.php#exercise");
        exit;
    } else {
        // If user does not exist, show error message
        $error_message = "Invalid email or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <div class="image-section">
            <img src="images/login.jpeg" alt="Sign Up Image">
        </div>
        <div class="form-section">
            <h2>Login</h2>
            <form action="" method="post">
                <!-- <label for="full-name">Full Name</label>
                <input type="text" id="full-name" name="full-name" placeholder="Name..."> -->
                <p class="error-msg">
                    <?php if (isset($error_message)) {
                        echo $error_message;
                    } ?>
                </p>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required value="<?= $email ?>">

                <!-- <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username..."> -->

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required value="<?= $password ?>">

                <!-- <label for="repeat-password">Repeat Password</label>
                <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat Password"> -->

                <!-- <div class="checkbox-container">
                    <input type="checkbox" id="terms" name="terms">
                    <label for="terms">I agree to the Terms of User</label>
                </div> -->

                <button type="submit">Login</button>
                <p class="endredirect-txt">Dont have a account? <a href="register.php" class="sign-in">Create New</a></p>
            </form>
        </div>
    </div>
</body>

</html>