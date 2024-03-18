<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: index.php');
    // Check the role of the logged-in user

    exit;
}

$role = $_SESSION['role'];
$id = $_SESSION['user_id'];


// Include database connection
require_once '../db.php';

// Initialize variables
$reports = [];
$message = '';

// Check if search input is provided
if (isset($_GET['searchInput'])) {
    $searchInput = $_GET['searchInput'];

    // Fetch reports from the database based on search criteria
    $sql = "SELECT * FROM reports WHERE submitted_by = $id AND (status LIKE '%$searchInput%' OR severity LIKE '%$searchInput%')";
    $result = $conn->query($sql);

    // Check if there are any reports matching the search criteria
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
    } else {
        $reports = []; // No reports found
        $message = '<div class="message" data-aos="fade-up">
        <h3>Sorry, You have no submissions so far. <br><a href="submit-report.php">Click here</a> to submit your first road damage report.</h3>
    </div>';
    }
} else {
    $searchInput = '';
    // Fetch all reports from the database if no search input is provided
    $sql = "SELECT * FROM reports WHERE submitted_by = $id";
    $result = $conn->query($sql);

    // Check if there are any reports
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
    } else {
        $reports = []; // No reports found
        $message = '<div class="message" data-aos="fade-up">
        <h3>Sorry, You have no submissions so far. <br><a href="submit-report.php">Click here</a> to submit your first road damage report.</h3>
    </div>';
    }
}
?>


<?php include 'top-header.php'?>


    <main class="main-workspage">

        <!-- Header -->
        <?php $page = 'Reports'; include 'header.php'?>

        <!-- Breadcrumb -->
 <section class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content" data-aos="fade-up">
                    <p>REPORTS - YOUR REPORTS</p>
                </div>
            </div>
        </section>

        <!-- Projects -->
        <section class="projects-area">
            <div class="container">
                <h1 class="section-heading" data-aos="fade-up"><img src="../assets/images/star-2-2.png" alt="Star"> All Projects <img src="../assets/images/star-2-2.png" alt="Star"></h1>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="section-heading desktop-head" data-aos="fade-up"><img src="../assets/images/star-2-2.png" alt="Star"> All Projects <img src="../assets/images/star-2-2.png" alt="Star"></h1>
                        
                       

                        <div class="wrapper" data-aos="fade-up">
                            <form method="GET" action="">
                                <div class="search-input">
                                    <input type="text" id="searchInput" name="searchInput" value="<?= $searchInput;?>" placeholder="Type to search..">
                                    <div class="icon">
                                         <button class="search-btn" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form> 
                        </div>

                        
                        <div class="tags-widget" data-aos="fade-up">
                                    <div class=" shadow-box">
                                        <ul class="tag-list-items">
                                            <li><button class="theme-btn" onclick="showAll()">All</button></li>
                                            <li><button class="theme-btn" onclick="showClass('Pending')">Pending</button></li>
                                            <li><button class="theme-btn" onclick="showClass('Progress')">In Progress</button></li>
                                            <li><button class="theme-btn" onclick="showClass('Resolved')">Resolved</button></li>
                                        </ul>

                                    </div>
                                </div>
                        </div>

                         <?= $message ?>







                        <div class="d-flex align-items-start gap-24">

                        <?php foreach ($reports as $report): ?>

                            <div data-aos="zoom-in" class="flex-1 report-box">
                                <div class="project-item shadow-box">
                                    <a class="overlay-link" onclick="viewReport(<?php echo $report['id']; ?>)"></a>
                                    <div class="project-img">
                                        <img src="../<?php echo $report['image']; ?>" alt="Project">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="project-info">
                                        <p>Report ID : <span><?php echo $report['id']; ?></span></p>
                                            <p>Status : <span><?php echo $report['status']; ?></span></p>
                                            <p>Damage Type : <span><?php echo $report['duration']; ?></span></p>
                                            <p>Date : <span><?php echo $report['submission_date']; ?></span></p>
                                            <p>Location : <span><?php echo $report['location']; ?></span></p>

                                        </div>
                                        <a onclick="viewReport(<?php echo $report['id']; ?>)" class="project-btn">
                                            <img src="../assets/images/icon-2.svg" alt="Button">
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>


                        </div>

                      
                    </div>

                </div>
            </div>
        </section>
        
<script>


function showClass(className) {
            var divs = document.querySelectorAll('.Resolved, .Pending, .Progress');
            for (var i = 0; i < divs.length; i++) {
                if (divs[i].classList.contains(className)) {
                    divs[i].classList.remove('hidden');
                } else {
                    divs[i].classList.add('hidden');
                }
            }
        }

        function showAll() {
            var divs = document.querySelectorAll('.Resolved, .Pending, .Progress');
            for (var i = 0; i < divs.length; i++) {
                divs[i].classList.remove('hidden');
            }
        }


        function viewReport(id) {
            window.location.href = "show_report.php?id=" + id;
        }

       
</script>

        <!-- Footer -->
            <?php include 'footer.php'?>

