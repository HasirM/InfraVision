<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
}
// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in
    $role = $_SESSION['role'];
    $username = $_SESSION['username'];
    $button = '<a href="logout.php" class="theme-btn">Logout</a>';
} else {
    $button = '<div class="nav-buttons"><a href="../login/signUp.php" class="theme-btn">Sign Up</a> <a href="../login/signIn.php" class="theme-btn">Sign In</a></div>';
    $username = 'Guest!';

}
?>

      
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from wpriverthemes.com/landing/gridx-html/light/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 Mar 2024 11:18:47 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gridx - Personal Portfolio HTML Template</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../../cdn.jsdelivr.net/gh/iconoir-icons/iconoir%40main/css/iconoir.css">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/aos.css">

    <link rel="stylesheet" href="../assets/css/style-light.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
 
       <!-- Header -->
        <header class="header-area">
            <div class="container">
                <div class="gx-row d-flex align-items-center justify-content-between flex-row">
                    <a href="index.php" class="logo">
                        <img src="../assets/images/logo-dark.svg" class="header-logo" alt="Logo">
                    </a>

                    <nav class="navbar">
                        <ul class="menu">
                            
                            <li class="<?php if ($page == 'home') echo 'active'; ?>"><a href="index.php">Home</a></li>
                            <li class=" <?php if ($page == 'about') echo 'active'; ?>"><a href="about.php">About</a></li>
                            <li class=" <?php if ($page == 'Reports') echo 'active'; ?>"><a href="Reports.php">Reports</a></li>
                            <li class=" <?php if ($page == 'contact') echo 'active'; ?>"><a href="contact.php">Contact</a></li>
                         </ul>
                        <?php echo $button; ?>
                    </nav>

                    <?php echo $button; ?>

                    <div class="show-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </header>
        <script>
           function Redirect(url){
            document.getElementbyClass
            this.class.add = 'active'

           } 
         </script>