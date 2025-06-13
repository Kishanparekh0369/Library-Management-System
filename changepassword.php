<?php
session_start();
$conn=mysqli_connect("localhost","root","","proj_libraryy");

$errorMessageNew = ""; 
$errorMessageConform = "";  
$errorMessageGeneral = "";  
$errorMessageLength = ""; 

if (isset($_POST['change'])) {
    $email = $_SESSION['email'];
    $new = $_POST['newpassword'];
    $conform = $_POST['conformpassword'];


    if (empty($new)) {
        $errorMessageNew = "New Password is required.";  
    } elseif (strlen($new) < 6) {
        $errorMessageLength = "Password must be at least 6 characters long."; 
    }

    if (empty($conform)) {
        $errorMessageConform = "Confirm Password is required.";  
    }

    if ($new && $conform && $new !== $conform) {
        $errorMessageGeneral = "Passwords do not match. Please try again.";  
    }

    // If no errors, proceed with updating the password
    if (empty($errorMessageNew) && empty($errorMessageConform) && empty($errorMessageGeneral) && empty($errorMessageLength)) {
        $sql = "UPDATE `student` SET `password`='$new' WHERE `email_id`='$email';";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $errorMessageGeneral = "Error: Password Not Updated.";  
        } else {
            echo "<script>alert('New Password Updated Successfully'); window.location.href = 'changepassword.php';</script>";
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>

    <link href="StyleSheet.css" rel="Stylesheet" type="text/css" />
</head>
<body>
    <?php
    include("hedfoot/userbar.php");
    ?>

    <div class="login">
        <form action="changepassword.php" method="post">
            <h2>CHANGE PASSWORD</h2><br>

            <label for="newpassword">NEW PASSWORD</label>
            <input type="password" name="newpassword" value="<?php echo isset($_POST['newpassword']) ? $_POST['newpassword'] : ''; ?>">
            <br>
            <?php
    
            if (!empty($errorMessageNew)) {
                echo "<div style='color:red; font-weight:bold;'>$errorMessageNew</div><br>";
            }
 
            if (!empty($errorMessageLength)) {
                echo "<div style='color:red; font-weight:bold;'>$errorMessageLength</div><br>";
            }
            ?>

            <label for="conformpassword">CONFIRM PASSWORD</label>
            <input type="password" id="password" name="conformpassword" value="<?php echo isset($_POST['conformpassword']) ? $_POST['conformpassword'] : ''; ?>">
            <br>
            <?php
          
            if (!empty($errorMessageConform)) {
                echo "<div style='color:red; font-weight:bold;'>$errorMessageConform</div><br>";
            }
            ?>

            <?php
         
            if (!empty($errorMessageGeneral)) {
                echo "<div style='color:red; font-weight:bold; text-align:center; margin-top: 10px;'>$errorMessageGeneral</div><br>";
            }
            ?>

            <button type="submit" id="align" name="change">CHANGE</button>
        </form>
    </div><br><br><br>

    <?php
    include("hedfoot/footer.php");
    ?>
</body>
</html>
