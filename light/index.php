<?php
// Include database connection
session_start();

// Check if the user is not logged in, redirect to login page
if (isset($role)) {
    $role = $_SESSION['role'];

    // Check the role of the logged-in user
    exit;
}else{
    $role = 'guest';
}


require_once '../db.php';

// Initialize variables
$totalReports = $resolvedReports = $pendingReports = $inProgressReports = 0;

// Fetch counts from the database
$sql_total = "SELECT COUNT(*) AS total FROM reports";
$sql_resolved = "SELECT COUNT(*) AS resolved FROM reports WHERE status = 'resolved'";
$sql_pending = "SELECT COUNT(*) AS pending FROM reports WHERE status = 'pending'";
$sql_in_progress = "SELECT COUNT(*) AS in_progress FROM reports WHERE status = 'in progress'";

// Execute queries
$result_total = $conn->query($sql_total);
$result_resolved = $conn->query($sql_resolved);
$result_pending = $conn->query($sql_pending);
$result_in_progress = $conn->query($sql_in_progress);

// Check if queries were successful
if ($result_total && $result_resolved && $result_pending && $result_in_progress) {
    // Fetch counts
    $totalReports = $result_total->fetch_assoc()['total'];
    $resolvedReports = $result_resolved->fetch_assoc()['resolved'];
    $pendingReports = $result_pending->fetch_assoc()['pending'];
    $inProgressReports = $result_in_progress->fetch_assoc()['in_progress'];
} else {
    echo "Error fetching counts: " . $conn->error;
}
?>

<?php include 'top-header.php'?>


    <main class="main-homepage">

    <?php $page = 'home'; include 'header.php'?>

        <!-- About -->
        <section class="about-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" data-aos="zoom-in">
                        <div class="about-me-box shadow-box">
                            <a class="overlay-link" href="#"></a>
                            <div class="img-box">
                                <img src="../assets/images/me.png" alt="About Me">
                            </div>
                            <div class="infos">
                                 <p>STREAMLINING REPORTS, EMPOWERING ACTION.</p>
                                 <div class="user-info">
                                <h4>Welcome,</h4>
                                <h1><?php echo $username?></h1>
                                </div>
                                <a href="#" class="about-btn">
                                    <img src="../assets/images/icon-2.svg" alt="Button">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="about-credentials-wrap">
                            <div data-aos="zoom-in">
                                <div class="banner shadow-box">
                                    <div class="marquee">
                                        <div>
                                          <span>VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star">VIEW ROAD DAMAGE <b>REPORTS</b> <img src="../assets/images/star1.svg" alt="Star"></span>
                                        </div>
                                      </div>
                                </div>

                            </div>
                            <div class="gx-row d-flex gap-24">

                         <?php if ($role == 'user') : ?>
                            <div data-aos="zoom-in">
                                    <div class="about-crenditials-box info-box shadow-box h-full">
                                        <a class="overlay-link" href="your-Reports.php"></a>
                                        <img src="../assets/images/sign.png" alt="Sign">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="infos">
                                                <h4>View your</h4>
                                                <h1>CONTRIBUTION.</h1>
                                            </div>
    
                                            <a href="your-Reports.php.php" class="about-btn">
                                                <img src="../assets/images/icon-2.svg" alt="Button">
                                            </a>
    
                                        </div>
                                    </div>
                                </div>
                        <?php elseif ($role == 'admin'): ?>
                            <div data-aos="zoom-in">
                                    <div class="about-crenditials-box info-box shadow-box h-full">
                                        <a class="overlay-link" href="users.php"></a>
                                        <img src="../assets/images/sign.png" alt="Sign">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="infos">
                                                <h4>Handle</h4>
                                                <h1>Users.</h1>
                                            </div>
    
                                            <a href="users.php" class="about-btn">
                                                <img src="../assets/images/icon-2.svg" alt="Button">
                                            </a>
    
                                        </div>
                                    </div>
                                </div>
                        <?php elseif ($role == 'guest' || $role == 'govt'): ?>
                        <?php else: ?>
                        <?php endif; ?>
                                

                                <div data-aos="zoom-in">
                                    <div class="about-project-box info-box shadow-box h-full">
                                        <a class="overlay-link" href="Reports.php"></a>
                                        <img src="../assets/images/my-works.png" alt="My Reports">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="infos">
                                                <h4>SHOWCASE</h4>
                                                <h1>All Reports.</h1>
                                            </div>
    
                                            <a href="#" class="about-btn">
                                                <img src="../assets/images/icon-2.svg" alt="Button">
                                            </a>
    
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-24">

                        <?php if ($role == 'admin'): ?>
                            <div class="col-md-12" data-aos="zoom-in">
                                <div class="about-client-box info-box shadow-box">
                                    <div class="clients d-flex align-items-start gap-24 justify-content-center">
                                        <div class="client-item">
                                            <h1><?php echo $totalReports; ?></h1>
                                            <p>Total <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $resolvedReports; ?></h1>
                                            <p>Resolved <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $inProgressReports; ?></h1>
                                            <p>In Progress<br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $pendingReports; ?></h1>
                                            <p>Pending<br>Reports</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($role == 'govt'): ?>
                            <div class="col-md-9" data-aos="zoom-in">    
                                <div class="about-client-box info-box shadow-box">
                                    <div class="clients d-flex align-items-start gap-24 justify-content-center">
                                        <div class="client-item">
                                            <h1><?php echo $totalReports; ?></h1>
                                            <p>Total <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $resolvedReports; ?></h1>
                                            <p>Resolved <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $inProgressReports; ?></h1>
                                            <p>In Progress<br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $pendingReports; ?></h1>
                                            <p>Pending<br>Reports</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" data-aos="zoom-in">
                                <div class="about-contact-box info-box shadow-box">
                                    <a class="overlay-link" href="about.php"></a>
                                    <img src="../assets/images/icon2-2.png" alt="Icon" class="star-icon">
                                    <h1>Know<br> <span>More.</span></h1>
                                    <a href="about.php" class="about-btn">
                                        <img src="../assets/images/icon-2.svg" alt="Button">
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6" data-aos="zoom-in">    
                                <div class="about-client-box info-box shadow-box">
                                    <div class="clients d-flex align-items-start gap-24 justify-content-center">
                                        <div class="client-item">
                                            <h1><?php echo $totalReports; ?></h1>
                                            <p>Total <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $resolvedReports; ?></h1>
                                            <p>Resolved <br>Reports</p>
                                        </div>

                                        <div class="client-item">
                                            <h1><?php echo $inProgressReports; ?></h1>
                                            <p>In Progress<br>Reports</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" data-aos="zoom-in">
                                <div class="about-contact-box info-box shadow-box">
                                    <a class="overlay-link" href="submit-report.php"></a>
                                    <img src="../assets/images/icon2-2.png" alt="Icon" class="star-icon">
                                    <h1>Make a Difference,<br> <span>Report Now.</span></h1>
                                    <a href="submit-report.php" class="about-btn">
                                        <img src="../assets/images/icon-2.svg" alt="Button">
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </section>

    <?php include 'footer.php'?>
