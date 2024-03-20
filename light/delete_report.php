<?php
// Include database connection
require_once '../db.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: ../login/signin.php');
    exit;
}

if ($_SESSION['role'] == 'user' || $_SESSION['role'] == 'govt') {
    header('location: index.php');
    exit;
}

// Check if report ID is provided in the request
if(isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // SQL query to delete the report
    $delete_sql = "DELETE FROM reports WHERE id = $report_id";

    // Execute the query
    if ($conn->query($delete_sql) === TRUE) {
        // Report deleted successfully
        echo '<script>alert("Report deleted successfully.");</script>';
    } else {
        // Error deleting report
        echo '<script>alert("Error deleting report: ' . $conn->error . '");</script>';
    }

    // Redirect back to the view report page
    echo '<script>window.location.href = "Reports.php";</script>';
} else {
    // If report ID is not provided in the request
    echo '<script>alert("Report ID not provided.");</script>';
    // Redirect back to the view report page
    echo '<script>window.location.href = "Reports.php";</script>';
}
?>
