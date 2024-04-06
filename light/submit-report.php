<?php 

// Start the session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: ../login/signin.php');
    exit;
}

if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'govt') {
    header('location: index.php');
    exit;
}

?>

<?php include 'top-header.php' ; include 'header.php'; ?>

<div class="cameraContainer"  data-aos="zoom-in">
    <video id="cameraFeed" autoplay></video>
     <button id="captureBtn" class="hidden">Capture Image</button>
</div>
<div id="confirmationContainer" class="hidden">
            <img id="capturedImage">
            <div class="report-proceed-btn">
                <button id="retakeBtn">Retake Image</button>
                <button id="proceedBtn">Proceed</button>
            </div>
        </div>

        <!-- Output container -->
        <div id="outputContainer" data-aos="zoom-in" class="hidden">
            <div class="custom-loader"></div>
            <div class="loading-text">
            <h3>
                <a href="" class="typewrite" data-period="2000" data-type='[ "AI Model Running,", "Please Wait."]'>
                    <span class="wrap"></span>
                </a>
                </h3>
            </div>
        </div>

        <div id="errorContainer" class="hidden">
        <i class='fas fa-exclamation-circle' style='font-size:80px;color:red'></i>
            <div class="error-text">
            <h3>
            No registered damages found. Please check your image.</h3> <h5> If issue still persists please contact admin. </h5> <h6 style="color:gray">redirecting...</h6>
                
            </div>
        </div>

        
        <div class="container px-5 my-5">
    <div id="reportForm" class="hidden">
         <h2>Report Form</h2>
<br>
         <div class="form-floating mb-3">
            <h6>Date</h6>
            <p class="label-report" id="date" ></p>
        </div>
         <div class="form-floating mb-3">
         <h6>Location</h6>
         <p class="label-report" id="location" ></p>

        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="landmark" type="text" placeholder="Landmark" data-sb-validations="" />
            <label for="landmark">Landmark</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="damageDuration" type="text" value="" placeholder="Type of Damage" data-sb-validations="" />
            <label for="damageDuration">Type of Damage</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="damageSeverity" type="text" placeholder="Impact/Severity of Damage" data-sb-validations="" />
            <label for="damageSeverity">Impact/Severity of Damage</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="additionalInfo" type="text" placeholder="Additional Information" style="height: 10rem;" data-sb-validations=""></textarea>
            <label for="additionalInfo">Additional Information</label>
        </div>
        <div class="d-grid">
            <button class="btn btn-primary btn-lg" id="submitReportBtn" type="submit">Submit</button>
        </div>
        <!-- <p id="errorMessage" class="error-message hidden">Please fill in all the required fields.</p> -->

    </div>
</div>


        <div class="modal" id="modal">
            <div id="modal-content" class="modal-content text-center mb-3">
                <span  id="modal-message" class="fw-bolder">Form submission successful!</span>
            </div>
        </div>

        <p class="text-center text-danger mb-3 hidden" id="errorMessage">Error sending message!</p>
        


        <form id="reportForm" class="hidden">
            <h2>Report Form</h2>
            <div id="capturedImageContainer"></div>
            <button id="retakeImageBtn" class="hidden">Retake Image</button>
            <p id="date"></p>
            <p>Your Location:<span id="location"></span></p>
            <label for="additionalInfo">Additional Information:</label>
            <textarea id="additionalInfo" placeholder="Enter additional information..." required></textarea>
            <label for="damageDuration">Duration of Damage:</label>
            <input type="text" id="damageDuration" placeholder="Enter duration of damage..." required>
            <label for="damageSeverity">Severity of Damage:</label>
            <input type="text" id="damageSeverity" placeholder="Enter severity of damage..." required>
            <label for="landmark">Landmark:</label>
            <input type="text" id="landmark" placeholder="Enter landmark..." required>
            <button type="submit" id="submitReportBtn">Submit</button>
              
        </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php include 'footer.php';?>   