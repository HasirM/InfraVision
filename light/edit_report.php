<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: ../login/signin.php');
    exit;
}


require_once '../db.php';

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    $sql = "SELECT * FROM reports WHERE id = $report_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
    } else {
        echo "No report found with the ID: $report_id";
        exit;
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
    echo "Report ID is not provided.";
    exit;
}


if ($_SESSION['role'] == 'user' && $_SESSION['user_id'] != $report['submitted_by']) {
    header('location: index.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $additional_info = $_POST['additional_info'];
    $duration = $_POST['duration'];
    $severity = $_POST['severity'];
    $status = $_POST['status'];
    $landmark = $_POST['landmark'];

    $last_updated_by = $_SESSION['user_id']; // Get the user ID from the session

    if ($status == "Resolved") {
        if (!empty($_FILES['confirm_image']['name'])) {
            $target_dir = "../assets/images/uploads/";
            $target_file = $target_dir . basename($_FILES["confirm_image"]["name"]);
            
            if (move_uploaded_file($_FILES["confirm_image"]["tmp_name"], $target_file)) {
                $update_sql = "UPDATE reports SET 
                    info = '$additional_info', 
                    duration = '$duration', 
                    severity = '$severity', 
                    status = '$status', 
                    landmark = '$landmark',
                    last_updated_by = $last_updated_by,
                    confirm_image = '$target_file',
                    last_updated_on = NOW()
                    WHERE id = $report_id";

                if ($conn->query($update_sql) === TRUE) {
                    echo '<script>alert("Report successfully updated.");</script>';
                    header("location:Reports.php");
                    exit;
                } else {
                    echo '<script>alert("Error updating report: ' . $conn->error . '");</script>';
                }
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
            }
        } else {
            echo '<script>alert("Please upload the resolved damage image.");</script>';
        }
    } else {
        $update_sql = "UPDATE reports SET 
            info = '$additional_info', 
            duration = '$duration', 
            severity = '$severity', 
            status = '$status', 
            landmark = '$landmark',
            last_updated_by = $last_updated_by,
            last_updated_on = NOW()
            WHERE id = $report_id";

        if ($conn->query($update_sql) === TRUE) {
            echo '<script>alert("Report successfully updated.");</script>';
            header("location:Reports.php");
            exit;
        } else {
            echo '<script>alert("Error updating report: ' . $conn->error . '");</script>';
        }
    }
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

?>


<?php include 'top-header.php'?>

    <main class="main-aboutpage">

        <!-- Header -->
        
        <?php include 'header.php'?>


        <!-- About -->
        <form method="post" action="" enctype="multipart/form-data">
        <section class="about-area">
            <div class="container">
                <div class="d-flex about-me-wrap align-items-start gap-24">
                    <div data-aos="zoom-in">
                        <div class="about-image-box shadow-box">
                            <div class="image-inner">
                                <img src="<?php echo $report['image']; ?>" alt="Report Image">
                            </div>
                        </div>
                    </div>

                    <div class="about-details" data-aos="zoom-in">
                        <h1 class="section-heading" data-aos="fade-up"><img src="../assets/images/star-2-2.png" alt="Star"> report-info <img src="../assets/images/star-2-2.png" alt="Star"></h1>
                        <div class="about-details-inner shadow-box">
                            <img src="../assets/images/icon2-2.png" alt="Star">
                            
                            <?php if ($role == 'user'): ?>
                                <?php echo $status; ?>
                                
                                <br><br>
                                
                            <?php else: ?>
                                <div class="status-btn">
                                    <select id="status" name="status">
                                        <option value="Pending" <?php if ($report['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="In Progress" <?php if ($report['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                        <option value="Resolved" <?php if ($report['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <!-- <h1><?php echo $report['duration']; ?></h1> -->
                            <h1><input type="text" id="duration" name="duration" value="<?php echo $report['duration']; ?>"></h1>

                                                    
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
                                            <p class="type"> 
                                                <input type="text" id="landmark" name="landmark" value="<?php echo $report['landmark']; ?>">
                                            </p>
                                        </li>
                                        <li>
                                            <h2>Impact/Severity of Damage</h2>
                                            <p class="type">
                                                <input type="text" id="severity" name="severity" value="<?php echo $report['severity']; ?>">

                                            </p>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12" data-aos="zoom-in">
                                <div class="about-edc-exp about-experience">
                                    <ul>
                                        <li>
                                            <h2>Additional Info</h2>
                                            <p class="type">
                                            <textarea rows='10' cols='50' id="additional_info" name="additional_info" ><?php echo $report['info']; ?></textarea>
                                            </p>
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
                            <?php if ($_SESSION['role'] == 'govt'): ?>
                                <input type="file" id="confirm_image" name="confirm_image">
                                <label for= "confirm_image">Upload resolved damage image.</label>
                            <?php else: ?>
                                <p>Not Updated</p>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>

                    <button class='theme-btn submit-report' type="submit">Update Report</button>

                </div>
                </form>

        <!-- Footer -->
            <?php include 'footer.php'?>
