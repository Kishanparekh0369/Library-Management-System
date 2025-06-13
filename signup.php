<?php
    $conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

    if (isset($_POST['b1'])) {
        $roll = $_POST['RollNo'];
        $f_name = $_POST['fullName'];
        $email = $_POST['email'];
        $m_no = $_POST['mobile'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $feild = $_POST['field'];
        $file = $_FILES["image"];
        $imgname = $_FILES["image"]["name"];
        $tmpn = $_FILES['image']["tmp_name"];

        $a = $roll;
        $e = $email;

        $sql = "SELECT roll_no,email_id FROM student WHERE roll_no='$a' OR email_id='$e';";
        $r = mysqli_query($conn, $sql);

        if (mysqli_num_rows($r) > 0) {
            echo "<script>alert('You are already registered!'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            $f = "img/" . $imgname;
            move_uploaded_file($tmpn, $f);

            $sql = "INSERT INTO `student`(`roll_no`, `f_name`, `email_id`, `m_no`, `password`, `gender`, `field`, `img`)
                    VALUES ('$roll','$f_name','$email','$m_no','$password','$gender','$feild','$f')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "<script>alert('Error: Data not inserted'); window.location.href = 'signup.php';</script>";
            } else {
                echo "<script>alert('Data inserted successfully'); window.location.href = 'login.php';</script>";
                exit();
            }
        }
    }
?>
<html>
<head>
    <link href="StyleSheet.css" rel="Stylesheet" type="text/css">
    <style>
      
        .error {
            color: red;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <?php include("hedfoot/heder.php"); ?>

    <div class="signup-form">
        <form action="signup.php" method="post" enctype="multipart/form-data" id="signupForm">
            <h2>User Sign-Up</h2><br>
            
            <label for="RollNo">Student Roll-No</label>
            <input type="text" name="RollNo" id="RollNo">
            <span class="error" id="RollNoError"></span>

            <br><label for="fullName">Full Name</label>
            <input type="text" name="fullName" id="fullName">
            <span class="error" id="fullNameError"></span>

            <br><label for="email">Email ID</label>
            <input type="email" name="email" id="email">
            <span class="error" id="emailError"></span>

            <br><label for="mobile">Mobile Number</label>
            <input type="tel" name="mobile" id="mobile" maxlength="10" oninput="validateMobile()">
            <span class="error" id="mobileError"></span>

            <br><label for="password">Password</label>
            <input type="password" id="password" name="password">
            <span class="error" id="passwordError"></span>

            <div class="form-group">
                <br><label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male"> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                    <label><input type="radio" name="gender" value="Other"> Other</label>
                </div>
            </div>
            <span class="error" id="genderError"></span>

            <div class="form-group">
                <br><label for="field">Field of Study</label>
                <select name="field" id="field">
                    <option value="">Select Your Field</option>
                    <option value="BCA">BCA</option>
                    <option value="MCA">MCA</option>
                    <option value="M.COM">M.COM</option>
                    <option value="B.COM">B.COM</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </div>
            <br><span class="error" id="fieldError"></span>

            <br><label for="image">Upload Your Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <br><span class="error" id="imageError"></span><br>

            <button type="submit" name="b1">Sign-Up</button>
        </form>
    </div><br><br><br>

    <?php include("hedfoot/footer.php"); ?>

    <script>
        document.getElementById("signupForm").addEventListener("submit", function(event) {
       
            let errors = false;
            let firstErrorField = null; 

   
            let rollNo = document.getElementById("RollNo").value;
            let fullName = document.getElementById("fullName").value;
            let email = document.getElementById("email").value;
            let mobile = document.getElementById("mobile").value;
            let password = document.getElementById("password").value;
            let gender = document.querySelector('input[name="gender"]:checked');
            let field = document.getElementById("field").value;
            let image = document.getElementById("image").files[0];

            if (rollNo === "") {
                document.getElementById("RollNoError").innerText = "Roll No is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "RollNo"; 
            } else if (!/^\d+$/.test(rollNo)) {
                document.getElementById("RollNoError").innerText = "Roll No must only contain digits";
                errors = true;
                if (!firstErrorField) firstErrorField = "RollNo"; 
            } else {
                document.getElementById("RollNoError").innerText = "";
            }

       
            if (fullName === "") {
                document.getElementById("fullNameError").innerText = "Full Name is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "fullName"; 
            } else if (!/^[a-zA-Z\s]+$/.test(fullName)) {
                document.getElementById("fullNameError").innerText = "Full Name must only contain letters and spaces";
                errors = true;
                if (!firstErrorField) firstErrorField = "fullName"; 
            } else {
                document.getElementById("fullNameError").innerText = "";
            }

            // Email Validation
            if (email === "") {
                document.getElementById("emailError").innerText = "Email is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "email"; 
            } else {
              
                email = email.toLowerCase();

                if (email !== document.getElementById("email").value) {
                    document.getElementById("emailError").innerText = "Email must be in lowercase";
                    errors = true;
                    if (!firstErrorField) firstErrorField = "email"; 
                } else if (!/\S+@\S+\.\S+/.test(email)) {
                    document.getElementById("emailError").innerText = "Invalid email format";
                    errors = true;
                    if (!firstErrorField) firstErrorField = "email"; 
                } else {
                    document.getElementById("emailError").innerText = "";
                }
            }

           
            if (mobile === "") {
                document.getElementById("mobileError").innerText = "Mobile Number is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "mobile"; 
            } else if (!/^\d{10}$/.test(mobile)) {
                document.getElementById("mobileError").innerText = "Mobile Number must be 10 digits";
                errors = true;
                if (!firstErrorField) firstErrorField = "mobile"; 
            } else {
                document.getElementById("mobileError").innerText = "";
            }

            if (password === "") {
                document.getElementById("passwordError").innerText = "Password is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "password"; 
            } else if (password.length < 6) {
                document.getElementById("passwordError").innerText = "Password must be at least 6 characters long";
                errors = true;
                if (!firstErrorField) firstErrorField = "password"; 
            } else {
                document.getElementById("passwordError").innerText = "";
            }

          
            if (!gender) {
                document.getElementById("genderError").innerText = "Gender is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "gender";
            } else {
                document.getElementById("genderError").innerText = "";
            }

       
            if (field === "") {
                document.getElementById("fieldError").innerText = "Field of Study is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "field"; 
            } else {
                document.getElementById("fieldError").innerText = "";
            }

            if (!image) {
                document.getElementById("imageError").innerText = "Image is required";
                errors = true;
                if (!firstErrorField) firstErrorField = "image"; 
            } else {
                let validExtensions = ['jpg', 'jpeg', 'png'];
                let fileExtension = image.name.split('.').pop().toLowerCase();

                if (image.size > 2 * 1024 * 1024) {
                    document.getElementById("imageError").innerText = "Image size must be less than 2MB";
                    errors = true;
                    if (!firstErrorField) firstErrorField = "image"; 
                } else if (!validExtensions.includes(fileExtension)) {
                    document.getElementById("imageError").innerText = "Image must be in .jpg, .jpeg, or .png format";
                    errors = true;
                    if (!firstErrorField) firstErrorField = "image"; 
                } else {
                    document.getElementById("imageError").innerText = "";
                }
            }

         
            if (errors) {
                event.preventDefault();
             
                document.getElementById(firstErrorField).focus();
            }
        });

    
        function validateMobile() {
            let mobileInput = document.getElementById("mobile");
            let value = mobileInput.value;
            if (value.length > 10) {
                mobileInput.value = value.slice(0, 10); 
            }
        }
    </script>
</body>
</html>
