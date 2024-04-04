<?php
session_start();

// Check if the user is not logged in, redirect to login page

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in
    $role = $_SESSION['role'];
    $id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $button = '<a href="logout.php" class="theme-btn">Logout</a>';
} else {
    $button = '<div class="nav-buttons"><a href="../login/signUp.php" class="theme-btn">Sign Up</a> <a href="../login/signIn.php" class="theme-btn">Sign In</a></div>';
    $username = 'Guest!';
    $role = 'guest';

}

// Include database connection
require_once '../db.php';


// Check if the report ID is provided in the URL
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Fetch the report details from the database based on the report ID
    $sql = "SELECT * FROM reports WHERE id = $report_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch the report details
        $report = $result->fetch_assoc();
    } else {
        // If no report found with the provided ID, display an error message
        echo "No report found with the ID: $report_id";
        exit; // Stop further execution
    }

    $user_sql = "SELECT * FROM users";
$user_result = $conn->query($user_sql);
if ($user_result->num_rows > 0) {
    // Fetch all users into an associative array
    $users = array();
    while ($row = $user_result->fetch_assoc()) {
        $users[$row['user_id']] = $row;
    }
} else {
    // If no users found, handle the error
    echo "No users found.";
    exit; // Stop further execution
}

} else {
    // If no report ID provided in the URL, display an error message
    echo "Report ID is not provided.";
    exit; // Stop further execution
}


// Check the value of $report['status'] and set $status accordingly
switch ($report['status']) {
    case 'Pending':
        $status = '<div class="status-btn pending">Pending</div>';
        break;
    case 'In Progress':
        $status = '<div class="status-btn inprogress">In Progress</div>';
        break;
    case 'Resolved':
        $status = '<div class="status-btn resolved">Resolved</div>';
        break;
    default:
        // Handle the case if $report['status'] is not any of the expected values
        $status = '<div class="status-btn unknown">Unknown</div>';
        break;
}

$submitted_id=$report['submitted_by'];
if (isset($submitted_id)) {
    $submit_username = $users[$submitted_id]['username']; 
} else {
    // Handle the case when the user ID doesn't exist in the $users array
    $submit_username = "Unknown"; // Or any default value you prefer
}

$updated_id=$report['last_updated_by'];
if (isset($updated_id)) {
    $update_username = $users[$updated_id]['username']; 
} else {
    // Handle the case when the user ID doesn't exist in the $users array
    $update_username = "Unknown"; // Or any default value you prefer
}

if(isset($report['confirm_image'])){
    $confirm_image = $report['confirm_image'];
}else{
    $confirm_image = 'assets\images\image_not_found.jpg';
}



?>

<?php include 'top-header.php'?>

    <main class="main-aboutpage">

        <!-- Header -->
        
        <?php include 'header.php'?>


        <!-- About -->
        <section class="about-area">
            <div class="container">
                <div class="d-flex about-me-wrap align-items-start gap-24">
                    <div data-aos="zoom-in">
                        <div class="about-image-box shadow-box">
                            <div class="image-inner">
                                <img src="<?php echo $report['image']; ?>" alt="Report Image">
                            </div>

                            
                        </div>
                        <?php if ($role == 'user' && ($report['status'] == 'Resolved' || $report['status'] == 'In Progress')) : ?>
                         <?php elseif ($role == 'user' && $id == $report['submitted_by']) : ?>
                            <div class="action-btn">
                                <button class="status-btn inprogress" onclick="editReport(<?php echo $report['id']; ?>)">Edit</button>
                            </div>
                        <?php elseif ($role == 'admin'): ?>
               
                            <div class="action-btn">
                                <button class="status-btn inprogress" onclick="editReport(<?php echo $report['id']; ?>)">Edit</button>
                                <button class="status-btn pending" onclick="deleteReport(<?php echo $report['id']; ?>)">Delete</button>
                            </div>
                        <?php elseif ($role == 'govt'): ?>
                            <div class="action-btn">
                                <button class="status-btn inprogress" onclick="editReport(<?php echo $report['id']; ?>)">Edit</button>
                            </div>
                        <?php else: ?>
                        <?php endif; ?>
                        <!-- <div class="action-btn">
                            <div class="status-btn inprogress" readonly>Edit</div>
                            <div class="status-btn pending" readonly>Delete</div>
                        </div> -->
                    </div>

                    <div class="row about-details" data-aos="zoom-in">
                        <h1 class="section-heading" data-aos="fade-up"><img src="../assets/images/star-2-2.png" alt="Star"> report-info <img src="../assets/images/star-2-2.png" alt="Star"></h1>
                        <div class="row">
                        <div class="about-details-inner shadow-box">
                            <img src="../assets/images/icon2-2.png" alt="Star">
                            
                            <?php echo $status; ?>
                            <br><br>
                            <p>Damage Type</p>
                            <h1><?php echo $report['duration']; ?></h1>
                        </div>
                        </div>

                    </div>
                </div>
               
                <div class="row mt-24">
                    <div class="col-md-12" data-aos="zoom-in">
                        <div class="row about-edc-exp about-experience shadow-box">
                            
                            <div class="col-md-6" data-aos="zoom-in">
                                <div class="about-edc-exp about-experience">
                                    <ul>
                                        <li>
                                            <h2>Report ID</h2>
                                            <p class="type"><?php echo $report['id']; ?></p>
                                        </li>
                                        <li>
                                            <h2>Location</h2>
                                            <p class="type"><?php echo $report['location']; ?></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="zoom-in">
                                <div class="about-edc-exp about-experience">
                                    <ul>
                                        <li>
                                            <h2>Landmark</h2>
                                            <p class="type"><?php echo $report['landmark']; ?></p>
                                        </li>
                                        <li>
                                            <h2>Impact/Severity of Damage</h2>
                                            <p class="type"><?php echo $report['severity']; ?></p>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-12" data-aos="zoom-in">
                                <div class="about-edc-exp about-experience">
                                    <ul>
                                        <li>
                                            <h2>Additional Info</h2>
                                            <p class="type"><?php echo $report['info']; ?></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>


                <div class="row mt-24">
                    <div class="col-md-6" data-aos="zoom-in">
                        <div class="about-edc-exp about-experience shadow-box">
                            <h3>SUBMISSION/UPDATION DETAILS</h3>

                            <ul>
                                <li>
                                    <h2>Submission Date</h2>
                                    <p class="type"><?php echo $report['submission_date']; ?></p>
                                </li>
                                <li>
                                    <h2>Submitted By</h2>
                                    <p class="type"><?php echo $submit_username;?></p>
                                </li>
                                <li>
                                    <h2>Last Updated Date</h2>
                                    <p class="type"><?php echo $report['last_updated_on']; ?></p>
                                </li>
                                <li>
                                    <h2>Updated By</h2>
                                    <p class="type"><?php echo $update_username;?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-6" data-aos="zoom-in">
                        <div class="about-edc-exp about-education shadow-box">
                            <h3>RESOLVED IMAGE</h3>
                            <div class="about-image-box shadow-box">
                            <div class="image-inner">
                                <img src="../<?php echo $confirm_image ?>" alt="About Me">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

        <!-- Footer -->
            <?php include 'footer.php'?>

            <script>
       
        // Function to edit report
        function editReport(id) {
            window.location.href = "edit_report.php?id=" + id;
        }

        // Function to delete report
        function deleteReport(reportId) {
        if (confirm("Are you sure you want to delete this report?")) {
            window.location.href = "delete_report.php?id=" + reportId;
        }
    }
    </script>