<?php
session_set_cookie_params(3600);
session_start();
if (isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit;
}
$username = "";
$password = "";
if (isset($_POST['username']) && isset($_POST['password'])) {
  include('../config/db_connect.php');
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare SQL statement to retrieve user from database
  $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if user exists in database
  if ($result->num_rows == 1) {
    // User exists, set session variables
    $_SESSION['admin'] = $username;
    // Redirect user to dashboard or another page
    header("Location: index.php");
    exit;
  } else {
    // If user does not exist, show error message
    $error_message = "Invalid username or password";
  }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADMIN | LOGIN</title>
  <link rel="stylesheet" href="./css/adminLogin.css" />
</head>

<body>

  <div class="container">
    <div class="screen">
      <div class="screen__content">
        <form class="login" action="" method="post">
          <h1>Admin Login</h1>
          <p class="error-msg">
            <?php if (isset($error_message)) {
              echo $error_message;
            } ?>
          </p>
          <div class="login__field">
            <i class="login__icon fas fa-user"></i>
            <input type="text" class="login__input" name="username" placeholder="Username" required value="<?php echo $username ?>">
          </div>
          <div class="login__field">
            <i class="login__icon fas fa-lock"></i>
            <input type="password" class="login__input" name="password" placeholder="Password" required value="<?php echo $password ?>">
          </div>
          <button type="submit" class="button login__submit">
            <span class="button__text">Log In</span>
            <i class="button__icon fas fa-chevron-right"></i>
          </button>
        </form>
        <!-- <div class="social-login">
                    <h3>log in via</h3>
                    <div class="social-icons">
                        <a href="#" class="social-login__icon fab fa-instagram"></a>
                        <a href="#" class="social-login__icon fab fa-facebook"></a>
                        <a href="#" class="social-login__icon fab fa-twitter"></a>
                    </div>
                </div> -->
      </div>
      <div class="screen__background">
        <span class="screen__background__shape screen__background__shape4"></span>
        <span class="screen__background__shape screen__background__shape3"></span>
        <span class="screen__background__shape screen__background__shape2"></span>
        <span class="screen__background__shape screen__background__shape1"></span>
      </div>
    </div>
  </div>
</body>

</html>