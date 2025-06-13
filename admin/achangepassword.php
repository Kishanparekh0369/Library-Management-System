<?php
session_start();
$conn=mysqli_connect("localhost","root","","proj_libraryy");

$new = $conform = "";
$newError = $conformError = "";

if(isset($_POST['submit']))
{
    $email=$_SESSION['emaliadmin'];
    $new=$_POST['newpassword'];
    $conform=$_POST['conformpassword'];

  
    if(empty($new)) {
        $newError = "New password is required.";
    } elseif(strlen($new) < 6) {
        $newError = "Password must be at least 6 characters long.";
    }

    if(empty($conform)) {
        $conformError = "Confirm password is required.";
    } elseif($new !== $conform) {
        $conformError = "Both passwords do not match.";
    }


    if(empty($newError) && empty($conformError)) {
        $sql="UPDATE `adminlog` SET `password`='$new' WHERE `email`='$email';";
        $result=mysqli_query($conn,$sql);

        if(!$result) {
            echo "<script>alert('Error: Password Not Updated'); window.location.href = 'achangepassword.php';</script>";
            exit();
        } else {
            echo "<script>alert('New Password Updated Successfully'); window.location.href = 'achangepassword.php';</script>";
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
    <link href="../StyleSheet.css" rel="Stylesheet" type="text/css" />
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
        }
    </style>
</head>
<body>
    <?php include("adminbar.php"); ?>

    <div class="login">
        <form action="achangepassword.php" method="post">
            <h2>CHANGE PASSWORD</h2><br>
            
            <label for="newpassword">NEW PASSWORD</label>
            <input type="password" name="newpassword" value="<?php echo $new; ?>">
            <?php if (!empty($newError)): ?>
                <br><span class="error"><?php echo $newError; ?></span><br>
            <?php endif; ?>

           <br><label for="conformpassword">CONFIRM PASSWORD</label>
            <input type="password" id="password" name="conformpassword"  value="<?php echo $conform; ?>">
            <?php if (!empty($conformError)): ?>
                <span class="error"><?php echo $conformError; ?></span>
            <?php endif; ?>

            <br><br><button type="submit" id="align" name="submit">CHANGE</button>

            &nbsp;&nbsp;&nbsp;<label><small><a href="adminhome.php" for="align">BACK TO HOME</a></small></label>
        </form>
    </div><br><br><br>

    <?php include("hedfoot/footer.php"); ?>
</body>
</html>
