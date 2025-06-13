<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

$errorMessage = ''; 
$errorNameMessage = ''; 

if (isset($_POST['update'])) {
    $email = $_SESSION['email'];
    $name = $_POST['fn'];
    $mno = $_POST['mn'];

    if (!preg_match('/^\d{10}$/', $mno)) {
        $errorMessage = 'Please enter a valid 10-digit mobile number.';
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errorNameMessage = 'Name should only contain letters and spaces, no digits allowed.';
    }

    if (empty($errorMessage) && empty($errorNameMessage)) {
        $q = "UPDATE `student` SET `f_name`='$name',`m_no`='$mno' WHERE `email_id`='$email';";
        $r = mysqli_query($conn, $q);

        if (!$r) {
            echo "<script>alert('Update failed'); window.location.href = 'myprofile.php';</script>";
            exit();
        } else {
            echo "<script>alert('Update successful'); window.location.href = 'myprofile.php';</script>";
            exit();
        }
    }
}

if (isset($_POST['pdf'])) {
    $emailS = $_SESSION['email'];
    $roll = $_SESSION['roll_no'];
    $QUE = "SELECT `roll_no`, `f_name`, `email_id`, `m_no`, `gender`, `field`, `reg_date`, `img` FROM `student` WHERE `email_id`='$emailS';";
    $resultsE = mysqli_query($conn, $QUE);

    if (mysqli_num_rows($resultsE) > 0) {
        foreach ($resultsE as $resultsq) {
            $date = "";
            $date .= "<h1 align='center' style='font-family: Arial, sans-serif; color: #333;'><u>MY PROFILE</u></h1><br><br>";

            $date .= "<table border='1' align='center' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 80%;'>";
            $date .= "<tr>";

            $date .= "<td rowspan='7' style='width: 200px; text-align: center; vertical-align: middle; padding: 20px;'>";
            $date .= "<img src='" . $resultsq['img'] . "' width='180' style='border-radius: 50%;'>";
            $date .= "</td>";

            $date .= "<td style='background-color: #f2f2f2;'><strong>Name:</strong></td><td>" . $resultsq['f_name'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Roll No:</strong></td><td>" . $resultsq['roll_no'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Email:</strong></td><td>" . $resultsq['email_id'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Gender:</strong></td><td>" . $resultsq['gender'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Mobile No:</strong></td><td>" . $resultsq['m_no'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Field:</strong></td><td>" . $resultsq['field'] . "</td></tr>";
            $date .= "<tr><td style='background-color: #f2f2f2;'><strong>Registration Date:</strong></td><td>" . $resultsq['reg_date'] . "</td></tr>";

            $date .= "</table><br><br><br><br><br><br>";

            require_once __DIR__ . '/vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($date);
            $mpdf->Output("myprofile.pdf", "D");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>
    <link href="StyleSheet.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
       
        function validateMobileNumber(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }

        function validateName(input) {
            input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); 
        }
    </script>
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php include("hedfoot/userbar.php"); ?>

    <div class="signup-form" style="width: 70%; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
        <form action="myprofile.php" method="post">
            <center><h1 style="font-weight: bold; text-decoration: underline; color: black;">MY PROFILE</h1></center><br><br>
            <?php
                $email = $_SESSION['email'];
                $sql = "SELECT `roll_no`, `f_name`, `email_id`, `m_no`, `gender`, `field`, `reg_date`, `img` FROM `student` WHERE `email_id`='$email';";
                $results = mysqli_query($conn, $sql);
                if (mysqli_num_rows($results) > 0) {
                    foreach ($results as $result) {
            ?>

            <table border="3" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <tr>
                    <td style="width: 30%; text-align: center; background-color: #f2f2f2; padding-bottom: 20px;">
                        <img src="<?php echo htmlspecialchars($result['img']); ?>" width="80%" height="auto" alt="Profile Image" style="padding: 10px; display: block; margin-left: auto; margin-right: auto;">
                    </td>
                    <td style="width: 70%; padding-left: 20px; text-align: left; background-color: #f2f2f2;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Roll Number:</td>
                                <td style="padding: 10px;"><?php echo htmlentities($result['roll_no']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Gender:</td>
                                <td style="padding: 10px;"><?php echo htmlentities($result['gender']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Field:</td>
                                <td style="padding: 10px;"><?php echo htmlentities($result['field']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Registration Date:</td>
                                <td style="padding: 10px;"><?php echo htmlentities($result['reg_date']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Full Name:</td>
                                <td style="padding: 10px;">
                                    <input type="text" name="fn" value="<?php echo htmlentities($result['f_name']); ?>" oninput="validateName(this)" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
                                    <?php if ($errorNameMessage): ?>
                                        <div class="error-message"><?php echo $errorNameMessage; ?></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Mobile Number:</td>
                                <td style="padding: 10px;">
                                    <input type="tel" name="mn" value="<?php echo htmlentities($result['m_no']); ?>" oninput="validateMobileNumber(this)" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
                                    <?php if ($errorMessage): ?>
                                        <div class="error-message"><?php echo $errorMessage; ?></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background-color: #f9f9f9; padding: 10px;">Email:</td>
                                <td style="padding: 10px;">
                                    <input type="text" name="email" value="<?php echo htmlentities($result['email_id']); ?>" required readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background-color: #f5f5f5; margin-top: 5px;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div style="text-align: center;">
                <button type="submit" name="update" style="background-color: #4CAF50; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; margin: 10px;">UPDATE</button>
                <button type="submit" name="pdf" style="background-color: #2196F3; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; margin: 10px;">DOWNLOAD INFORMATION</button>
            </div>

        <?php }} ?>
        </form>
    </div>

    <?php include("hedfoot/footer.php"); ?>
</body>
</html>
