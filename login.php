<!DOCTYPE html>
<html>
<head id="Head1" runat="server">
    <title>Login</title>
    <link href="StyleSheet.css" rel="Stylesheet" type="text/css" />
    <style>
        .login label,
        .login button {
            display: inline-block;
            vertical-align: middle;
            gap: 30px;
        }

        .error {
            color: red;
            font-weight: bold;
            font-size: 14px;
        }

        .login input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <?php
        include("hedfoot/heder.php");
    ?>

    <div class="login">
        <form action="login.php" method="post" onsubmit="return validateForm()">
            <h2>User Login</h2><br>
            <label for="email">Email ID</label>
            <input type="email" id="email" name="email">
            <br><div id="emailError" class="error"></div>

            <br><label for="password">Password</label>
            <input type="password" id="password" name="password">
            <br><div id="passwordError" class="error"></div><br>

            <button type="submit" id="align" name="submit">Login</button>
            &nbsp;&nbsp;&nbsp;<label><small><a href="signup.php" for="align"> DON'T HAVE ACCOUNT?</a></small></label>
        </form>
    </div><br><br><br><br>

    <?php
        include("hedfoot/footer.php");
    ?>
</body>

<script>
    function validateForm() {
     es
        document.getElementById('emailError').innerText = '';
        document.getElementById('passwordError').innerText = '';

        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        var valid = true;

  
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
      
        if (!email) {
            document.getElementById('emailError').innerText = 'Please enter an email address.';
            valid = false;
        } else if (!emailPattern.test(email)) {
            document.getElementById('emailError').innerText = 'Please enter a valid email address.';
            valid = false;
        } else {
        
            if (email !== email.toLowerCase()) {
                document.getElementById('emailError').innerText = 'Email must be in lowercase.';
                valid = false;
            }
        }

       
        if (!password) {
            document.getElementById('passwordError').innerText = 'Please enter a password';
            valid = false;
        } else if (password.length < 6) {
            document.getElementById('passwordError').innerText = 'Password must be at least 6 characters long.';
            valid = false;
        }

        return valid;
    }
</script>

</html>

<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT `email_id`, `roll_no`, `password` FROM `student` WHERE `email_id`='$email' AND `password`='$password';";
    $result = mysqli_query($conn, $sql);

   
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email_id'];
        $_SESSION['roll_no'] = $row['roll_no'];
        echo "<script>alert('Login successfully'); window.location.href = 'userdashborde.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Wrong Email or Password'); window.location.href = 'login.php';</script>";
    }
}
?>
