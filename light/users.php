<?php
// Include database connection
require_once '../db.php';

// Initialize variables for success and error messages
$successMessage = "";
$errorMessage = "";

// Function to update user role
function updateUserRole($userId, $newRole, $conn) {
    $sql = "UPDATE users SET role = '$newRole' WHERE user_id = $userId";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if form is submitted for role update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId']) && isset($_POST['newRole'])) {
        $userId = $_POST['userId'];
        $newRole = $_POST['newRole'];
        if (updateUserRole($userId, $newRole, $conn)) {
            $successMessage = "Role updated successfully!";
        } else {
            $errorMessage = "Error updating role.";
        }
    }
}
// Check if search input is provided
if (isset($_GET['searchInput'])) {
    $searchInput = $_GET['searchInput'];

    // Fetch reports from the database based on search criteria
    $sql = "SELECT * FROM users WHERE role != 'admin' AND (user_id LIKE '%$searchInput%' OR username LIKE '%$searchInput%' OR email LIKE '%$searchInput%' OR phone_number LIKE '%$searchInput%' OR role LIKE '%$searchInput%')";
    // Check if there are any reports matching the search criteria
    $result = $conn->query($sql);

    // Check if there are any users
    if ($result->num_rows > 0) {
        // Store users in an array
        $users = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $users = []; // No reports found
        $message = '<div class="message" data-aos="fade-up">
        <h3>Sorry, There are no registered accounts so far. <br><a href="index.php">Click here</a> to go to home.</h3>
    </div>';
    }
} else {
    // Fetch all reports from the database if no search input is provided
    $searchInput = '';
    // Fetch users from the database
    $sql = "SELECT * FROM users WHERE role != 'admin'";
    $result = $conn->query($sql);

    // Check if there are any users
    if ($result->num_rows > 0) {
        // Store users in an array
        $users = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $users = []; // No users found
        $message = '<div class="message" data-aos="fade-up">
        <h3>Sorry, There are no registered accounts so far. <br><a href="index.php">Click here</a> to go to home.</h3>
    </div>';
    }
}

?>

<?php include 'top-header.php'; ?>
<?php include 'header.php'; ?>

<div class="container mt-3 mb-4">
    <div class="col-lg-9 mt-4 mt-lg-0 user-container">
        <div class="row">
            <div class="col-md-12 users-container-table">
                <!-- Display success message -->
                <?php if (!empty($successMessage)) : ?>
                    <div id="successMessage" class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <!-- Display error message -->
                <?php if (!empty($errorMessage)) : ?>
                    <div id="errorMessage" class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>

                <div class="wrapper" data-aos="zoom-in">
                    <form method="GET" action="">
                        <div class="search-input">
                            <input type="text" id="searchInput" name="searchInput" value="<?= $searchInput;?>" placeholder="Type to search..">
                            <div class="icon">
                                    <button class="search-btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form> 
                </div>


                <div data-aos="fade-up" class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
                    <table class="table manage-candidates-top mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">Username</th>
                                <th class="text-center">Status</th>
                                <th class="action text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr class="candidates-list">
                                    <td class="title">
                                        <div class="thumb">
                                            <img class="img-fluid" src="../assets/images/me.png" alt="">
                                        </div>
                                        <div class="candidate-list-details">
                                            <div class="candidate-list-info">
                                                <div class="candidate-list-title">
                                                    <h5 class="mb-0"><a href="#"><?php echo $user['username']; ?></a></h5>
                                                </div>
                                                <div class="candidate-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fas fa-envelope pr-1"></i><?php echo $user['email']; ?></li>
                                                        <li><i class="fas fa-phone pr-1"></i><?php echo $user['phone_number']; ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="candidate-list-favourite-time text-center">
                                        <span class="candidate-list-time order-1"><?php echo $user['role']; ?></span>
                                    </td>
                                    <td class="user-action-btn">
                                    <button onclick="showUpdate()">Edit Role</button>

                                    <!-- Modal for updating role -->
                                    <div id="updateModal" class="user-modal">
                                        <div class="user-modal-content">
                                            <span class="close" onclick="hideUpdateModal()">&times;</span>
                                            <form id="updateForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <input type="hidden" name="userId" value="<?php echo $user['user_id']; ?>">
                                                <select class="user-role-select" name="newRole">
                                                <?php 
                                                    // Display the current role as the first option
                                                    echo '<option value="' . $user['role'] . '" selected>' . $user['role'] . '</option>';
                                                    
                                                    // Display other options excluding the current role
                                                    $roles = array("user", "govt");
                                                    foreach ($roles as $role) {
                                                        if ($role != $user['role']) {
                                                            echo '<option value="' . $role . '">' . $role . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <button type="submit">Update Role</button>
                                            </form>
                                        </div>
                                    </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to hide message after a certain period of time
    function hideMessage() {
        var messageContainer = document.getElementById('messageContainer');
        var successMessage = document.getElementById('successMessage');
        var errorMessage = document.getElementById('errorMessage');

        
        // Check if success message exists and hide it after 5 seconds
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
                window.location.href = window.location.href;
            }, 3000);
        }

        // Check if error message exists and hide it after 5 seconds
        if (errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 3000);
        }
    }

    // Call hideMessage function when the page loads
    window.onload = function() {
        hideMessage();
    };

    // Function to show the update modal
    function showUpdate() {
        var modal = document.getElementById('updateModal');
        modal.style.display = 'block';
    }

    // Function to hide the update modal
    function hideUpdateModal() {
        var modal = document.getElementById('updateModal');
        modal.style.display = 'none';
    }

</script>


<?php include 'footer.php'; ?>
