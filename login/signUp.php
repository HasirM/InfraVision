<?php
// Include the database connection
require_once '../db.php';

// Initialize variables
$username = $password = $confirm_password = $email = $phone_number = '';
$username_err = $password_err = $confirm_password_err = $email_err = $phone_number_err = '';

// Process form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter your username.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm your password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate phone number
    if (empty(trim($_POST['phone_number']))) {
        $phone_number_err = 'Please enter your phone number.';
    } else {
        $phone_number = trim($_POST['phone_number']);
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($phone_number_err)) {
        $sql = "INSERT INTO users (username, email, password, phone_number) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $param_username, $param_email, $param_password, $param_phone_number);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash password
            $param_phone_number = $phone_number;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header('location: signIn.php');
                exit();
            } else {
                $error_message = 'Something went wrong. Please try again later.';
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="icon" href="../assets/images/logo.svg" type="image/icon type">

    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="log-main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign Up</h2>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username"  value="<?php echo htmlspecialchars($username); ?>"/>
            <span><?php echo $username_err; ?></span>

                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="<?php echo htmlspecialchars($email); ?>"/>
            <span><?php echo $email_err; ?></span>

                            </div>
                            <div class="form-group">
                                <label for="phone_number"><i class="zmdi zmdi-phone"></i></label>
                                <input type="text" name="phone_number" id="phone_number" placeholder="Your Phone Number" value="<?php echo htmlspecialchars($phone_number); ?>"/>
                                <span><?php echo $phone_number_err; ?></span>


                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
            <span><?php echo $password_err; ?></span>

                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password"/>
            <span><?php echo $confirm_password_err; ?></span>

                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signIn.php" class="signup-image-link">I am already member</a>
                    </div>
                    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>