<?php
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

$studentName = '';
$bookDetails = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['submit'])) {
        $studentid = strtoupper(trim($_POST['roll_no']));
        $bookid = $_POST['isbn'];

        if (empty($studentid)) {
            $error = "Student ID is required.";
        } elseif (!is_numeric($studentid)) {
            $error = "Student ID must be a valid number.";
        } elseif (empty($bookid)) {
            $error = "ISBN Number is required.";
        } elseif (!is_numeric($bookid)) {
            $error = "ISBN Number must be a valid number.";
        } else {
            
            $C = 1;
            $sql10 = "SELECT `id` FROM `addbooks` WHERE `isIssued`='$C' AND `ISBNNumber`='$bookid';";
            $re10 = mysqli_query($conn, $sql10);

            if (mysqli_num_rows($re10) > 0) {
                echo "<script>alert('Error: this Book Already Issued'); window.location.href = 'issuebook.php';</script>";
                exit();
            } else {
                $sql0 = "SELECT `id` FROM `addbooks` WHERE `ISBNNumber`='$bookid';";
                $result0 = mysqli_query($conn, $sql0);

                if ($result0 && mysqli_num_rows($result0) > 0) {
                    $isissued = 1;
                    $rows = mysqli_fetch_assoc($result0);
                    $id = $rows['id'];
                    $insertQuery = "INSERT INTO issuedbook(roll_no, BookId) VALUES('$studentid', '$id')";
                    $updateQuery = "UPDATE addbooks SET isIssued = '$isissued' WHERE id = '$id'";

                    $insertResult = mysqli_query($conn, $insertQuery);
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($insertResult && $updateResult) {
                        echo "<script>alert('Book issued successfully'); window.location.href = 'adminhome.php';</script>";
                        exit();
                    } else {
                        echo "<script>alert('Error: Book not issued'); window.location.href = 'issuebook.php';</script>";
                        exit();
                    }
                } else {
                    $error = "Invalid ISBN Number.";
                }
            }
        }
    }

   
    if (isset($_POST['view'])) {
        $studentid = strtoupper(trim($_POST['roll_no']));
        $bookid = trim($_POST['isbn']);

       
        if (!empty($studentid)) {
            $sql = "SELECT * FROM student WHERE roll_no = '$studentid'";
            $result1 = mysqli_query($conn, $sql);

            if (!$result1 || mysqli_num_rows($result1) === 0) {
                $error = "No student found with ID: $studentid";
            }
        }

     
        if (!empty($bookid)) {
            $sql = "SELECT addbooks.id, addbooks.BookName, author.author_name, addbooks.bookImage, addbooks.ISBNNumber 
                    FROM addbooks 
                    JOIN author ON author.aid = addbooks.AuthorId 
                    WHERE addbooks.ISBNNumber = '$bookid'";
            $results = mysqli_query($conn, $sql);

            if (!$results || mysqli_num_rows($results) === 0) {
                $error = "No book found with ISBN: $bookid";
            }
        }
    }
}
?>

<html>
<head>
    <title>Library Management System - Issue Book</title>
    <link href="../StyleSheet.css" rel="stylesheet" type="text/css" />
    <style>
        .signup-form label, .signup-form button {
            display: inline-block;
            vertical-align: middle;
        }

        .book-card {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .book-card img {
            margin-right: 10px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

      
    </style>
    <script>
        function validateForm() {
            var rollNo = document.getElementById("studentId");
            var isbn = document.getElementById("isbn");

            var valid = true;

            document.getElementById("rollNoError").innerHTML = "";
            document.getElementById("isbnError").innerHTML = "";

       
            if (rollNo.value.trim() === "") {
                document.getElementById("rollNoError").innerHTML = "Student ID is required.";
                valid = false;
            } else if (isNaN(rollNo.value)) {
                document.getElementById("rollNoError").innerHTML = "Student ID must be a valid number.";
                valid = false;
            }

          
            if (isbn.value.trim() === "") {
                document.getElementById("isbnError").innerHTML = "ISBN Number is required.";
                valid = false;
            } else if (isNaN(isbn.value)) {
                document.getElementById("isbnError").innerHTML = "ISBN Number must be a valid number.";
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>
    <?php include("adminbar.php"); ?>

    <div class="signup-form">
        <h1 align="center">ISSUE BOOK</h1>
        <form action="issuebook.php" method="POST" onsubmit="return validateForm()">
        
            <label>Student ID</label>
            <input type="text" id="studentId" name="roll_no">
            <div id="rollNoError" class="error"></div>

            <?php if (!empty($result1) && mysqli_num_rows($result1) > 0): ?>
                <?php $row = mysqli_fetch_assoc($result1); ?>
                <div>
                    <p><strong><?php echo htmlspecialchars($row['f_name']); ?></strong></p>
                    <p><?php echo htmlspecialchars($row['email_id']); ?></p>
                    <p><?php echo htmlspecialchars($row['m_no']); ?></p>
                </div>
            <?php endif; ?><br><br>

        
            <label>Book ISBN Number</label>
            <input type="text" id="isbn" name="isbn">
            <div id="isbnError" class="error"></div>

            <?php if (!empty($results) && mysqli_num_rows($results) > 0): ?>
                <?php $book = mysqli_fetch_assoc($results); ?>
                <div class="book-card">
                    <img src="<?= htmlspecialchars($book['bookImage']) ?>" alt="<?= htmlspecialchars($book['BookName']) ?>" width="100px">
                    <div>
                        <p><strong><?= htmlspecialchars($book['BookName']) ?></strong></p>
                        <p><?= htmlspecialchars($book['author_name']) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <button type="submit" name="view">VIEW DETAILS</button>
            <button type="submit" name="submit">Issue Book</button>
        </form>

        <?php if ($error): ?>
            <div style="color: red; margin-top: 10px;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div><br><br><br><br>

    <?php include("hedfoot/footer.php"); ?>
</body>
</html>
