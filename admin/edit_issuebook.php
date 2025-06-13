<?php
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

if (isset($_POST['return'])) {
    $id = $_GET['edi'];
    $fine = $_POST['fine'];
    $rstatus = 1;
    $isissued = 0;
    $bookid = $_POST['bookid'];


    if (empty($fine)) {
        echo "<script>alert('Error: Fine is required'); window.location.href = 'edit_issuebook.php';</script>";
        exit();
    }

    if (!is_numeric($fine)) {
        echo "<script>alert('Error: Only numbers are allowed for the fine'); window.location.href = 'edit_issuebook.php';</script>";
        exit();
    }

 
    $sql = "UPDATE issuedbook SET RetrunStatus = '$rstatus', fine = '$fine' WHERE id = '$id';";
    $result0 = mysqli_query($conn, $sql);

    if ($result0) {
     
        $sql0 = "UPDATE addbooks SET isIssued = '$isissued' WHERE id = '$bookid';";
        $re = mysqli_query($conn, $sql0);

        if (!$re) {
            echo "<script>alert('Error: Book Not Returned'); window.location.href = 'edit_issuebook.php';</script>";
            exit();
        } else {
            echo "<script>alert('Book Returned Successfully'); window.location.href = 'manageissuebook.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: Book Not Returned'); window.location.href = 'edit_issuebook.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Return</title>
    <script>
       
        function validateForm() {
            var fine = document.getElementById("fine").value;
            var errorMsg = document.getElementById("fineError");

          
            errorMsg.textContent = "";

     
            if (fine == "") {
                errorMsg.textContent = "Fine is required!";
                errorMsg.style.color = "red";
                errorMsg.style.fontWeight = "bold";
                return false; 
            }

        
            var regex = /^[0-9]*\.?[0-9]+$/; 
            if (!regex.test(fine)) {
                errorMsg.textContent = "Only numbers are allowed!";
                errorMsg.style.color = "red";
                errorMsg.style.fontWeight = "bold";
                return false; 
            }

            return true; 
        }
    </script>
</head>
<body>
    <?php include("adminbar.php"); ?>

    <form action="" method="POST" onsubmit="return validateForm()">
        <div style="border: 1px solid #d1e7f7; border-radius: 5px; padding: 20px; background-color: #f8f9fa; width: 800px; margin: 20px auto;">
            <h2 style="background-color: #d1e7f7; padding: 10px; border-radius: 5px; text-align: center;">Issued Book Details</h2>

            <?php
            $id = $_GET['edi'];
            $sql = "SELECT issuedbook.id, issuedbook.fine, student.f_name, student.email_id, student.m_no, student.roll_no, 
                           addbooks.BookName, addbooks.id as bid, addbooks.ISBNNumber, issuedbook.IssuesDate, issuedbook.ReturnDate, 
                           addbooks.bookImage, issuedbook.RetrunStatus
                    FROM issuedbook
                    JOIN addbooks ON issuedbook.BookId = addbooks.id
                    JOIN student ON issuedbook.roll_no = student.roll_no 
                    WHERE issuedbook.id = '$id';";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            ?>

            <input type="hidden" name="bookid" value="<?php echo htmlentities($row['bid']); ?>">

            <div style="margin-top: 20px;">
                <h3>Student Details</h3><br>
                <p><strong>Student Roll Number:</strong> <?php echo htmlspecialchars($row['roll_no']); ?></p><br>
                <p><strong>Student Name:</strong> <?php echo htmlspecialchars($row['f_name']); ?></p><br>
                <p><strong>Student Email ID:</strong> <?php echo htmlspecialchars($row['email_id']); ?></p><br>
                <p><strong>Student Contact No:</strong> <?php echo htmlspecialchars($row['m_no']); ?></p><br><br>
            </div>

            <div style="margin-top: 20px;">
                <h3>Book Details</h3><br>
                <div style="display: flex; align-items: flex-start; margin-top: 10px;">
                    <div>
                        <img src="<?php echo htmlspecialchars($row['bookImage']); ?>" alt="Book Image" style="width: 150px; height: auto; border: 1px solid #ccc; padding: 5px;">
                    </div>
                    <div style="margin-left: 20px;">
                        <p><strong>Book Name:</strong> <?php echo htmlspecialchars($row['BookName']); ?></p><br>
                        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($row['ISBNNumber']); ?></p><br>
                        <p><strong>Book Issued Date:</strong> <?php echo htmlspecialchars($row['IssuesDate']); ?></p><br>
                        <p><strong>Book Returned Date:</strong> 
                            <?php echo ($row['ReturnDate'] == "") ? "Not Returned Yet" : htmlspecialchars($row['ReturnDate']); ?>
                        </p><br>
                        <p><strong>Fine:</strong> 
                            <input type="text" name="fine" id="fine" value="<?php echo htmlspecialchars($row['fine']); ?>">
                            <span id="fineError"></span> <!-- Error message will be shown here -->
                        </p><br>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <?php if (!$row['RetrunStatus']) { ?>
                    <button type="submit" name="return" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Return</button>
                <?php } else { ?>
                    <p style="color: green;">Book Already Returned</p>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </form>

    <?php include("hedfoot/footer.php"); ?>
</body>
</html>
