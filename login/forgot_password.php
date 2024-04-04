<?php
require_once '../db.php'; // Assuming this file contains database connection code using MySQLi

$username = $email_phone = $new_password = $confirm_password = '';
$username_err = $email_phone_err = $new_password_err = $confirm_password_err = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username, email, or phone number
    $username = trim($_POST['username']);
    $email_phone = trim($_POST['email_phone']);

    // Validate new password
    $new_password = trim($_POST['new_password']);
    if (empty($new_password)) {
        $new_password_err = 'Please enter the new password.';
    } elseif (strlen($new_password) < 6) {
        $new_password_err = 'Password must have at least 6 characters.';
    }

    // Validate confirm password
    $confirm_password = trim($_POST['confirm_password']);
    if (empty($confirm_password)) {
        $confirm_password_err = 'Please confirm the password.';
    } elseif ($new_password != $confirm_password) {
        $confirm_password_err = 'Password does not match.';
    }

    // Check input errors before updating the password
    if (empty($username_err) && empty($email_phone_err) && empty($new_password_err) && empty($confirm_password_err)) {
        // Check if the username, email, or phone number exists in the database
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? OR phone_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email_phone, $email_phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Username, email, or phone number exists, update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE users SET password = ? WHERE username = ? OR email = ? OR phone_number = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('ssss', $hashed_password, $username, $email_phone, $email_phone);

            if ($stmt_update->execute()) {
                // Password updated successfully
                $success_message = 'Password updated successfully. Redirecting to login page...';
                header("refresh:3;url=../light/index.php");
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
        } else {
            $email_phone_err = 'No account found with that username, email, or phone number.';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

    <!-- Font Icon -->
    <link rel="icon" href="../assets/images/logo.svg" type="image/icon type">
 
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Forgot Password</h2>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username"  value="<?php echo htmlspecialchars($username); ?>"/>
            <span><?php echo $username_err; ?></span>

                            </div>
                            <div class="form-group">
                                <label for="email_phone"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email_phone" id="email_phone" placeholder="Your Email/Phone Number" value="<?php echo htmlspecialchars($email_phone); ?>"/>
            <span><?php echo $email_phone_err; ?></span>

                            </div>
                            <div class="form-group">
                            <label for="confirm_password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="new_password" id="new_password" placeholder="Your New Password"/>
                                <span><?php echo $new_password_err; ?></span>


                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password"/>
            <span><?php echo $confirm_password_err; ?></span>

                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="reset_password" id="reset_password" class="form-submit" value="Reset Password"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signIn.php" class="signup-image-link">Back</a>
                    </div>
                    <?php if (!empty($success_message)) : ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>