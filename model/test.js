document.getElementById("detectButton").addEventListener("click", function() {
    const axios = require("axios");
    const fs = require("fs");

    const imageInput = document.getElementById("imageInput");
    const imageFile = imageInput.files[0];

    if (imageFile) {
        const reader = new FileReader();
        reader.readAsDataURL(imageFile);
        reader.onload = function () {
            const imageBase64 = reader.result.split(",")[1];

            axios({
                method: "POST",
                url: "https://detect.roboflow.com/road-defect-3/8",
                params: {
                    api_key: "atX07olX4RozfLzMxIx9"
                },
                data: imageBase64,
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            })
            .then(function(response) {
                console.log(response.data);
                alert("Potholes detected!");
            })
            .catch(function(error) {
                console.log(error.message);
                alert("Error: " + error.message);
            });
        };
    } else {
        alert("Please select an image file.");
    }
});
