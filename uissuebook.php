<?php
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");


session_start();
$emailS = $_SESSION['email'];
$roll = $_SESSION['roll_no'];
if (isset($_POST['pdf'])) {

    $studentQuery = "SELECT `roll_no`, `f_name`, `email_id`,`m_no` FROM `student` WHERE `email_id` = '$emailS'";
    $studentResult = mysqli_query($conn, $studentQuery);
    $studentInfo = mysqli_fetch_assoc($studentResult);

 
    $sql = "SELECT addbooks.BookName, addbooks.ISBNNumber, issuedbook.IssuesDate, issuedbook.ReturnDate,issuedbook.fine FROM `issuedbook` join addbooks on issuedbook.BookId=addbooks.id AND `roll_no` = '$roll'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $html = "";

        $html .= "<h1 align='center' style='font-family: Arial, sans-serif; color: #333;'><u>Student Issue Book Report</u></h1><br><br>";
        $html .= "<table border='1' align='center' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 60%;'>";
        $html .= "<tr><td style='background-color: #f2f2f2;'><strong>Name:</strong></td><td>" . $studentInfo['f_name'] . "</td></tr>";
        $html .= "<tr><td style='background-color: #f2f2f2;'><strong>Roll No:</strong></td><td>" . $studentInfo['roll_no'] . "</td></tr>";
        $html .= "<tr><td style='background-color: #f2f2f2;'><strong>Email:</strong></td><td>" . $studentInfo['email_id'] . "</td></tr>";
        $html .= "<tr><td style='background-color: #f2f2f2;'><strong>Phone Number:</strong></td><td>" . $studentInfo['m_no'] . "</td></tr>";
        $html .= "</table><br><br>";

  
        $html .= "<h2 align='center' style='font-family: Arial, sans-serif; color: #333;'>Issue Book List</h2>";
        $html .= "<table border='1' align='center' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
        $html .= "<tr style='background-color: #4CAF50; color: white;'>";
        $html .= "<th>NO</th><th>Book Name</th><th>ISBN</th><th>Issue Date</th><th>Return Date</th><th>Fine</th>";
        $html .= "</tr>";

        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $returnDate = ($row['ReturnDate'] == NULL || $row['ReturnDate'] == '') ? "Not Return Yet" : $row['ReturnDate'];
            $fine = ($row['ReturnDate'] == NULL || $row['ReturnDate'] == '') ? "Not Return Yet" : $row['fine'];
            $html .= "<tr>";
            $html .= "<td>" . $count . "</td>";
            $html .= "<td>" . $row['BookName'] . "</td>";
            $html .= "<td>" . $row['ISBNNumber'] . "</td>";
            $html .= "<td>" . $row['IssuesDate'] . "</td>";
            $html .= "<td>" . $returnDate . "</td>";
            $html .= "<td>" . $fine . "</td>";
            $html .= "</tr>";
            $count++;
        }

        $html .= "</table><br><br>";

        require_once __DIR__ . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("student_issuebook_list.pdf", "D");
    } else {
        echo "No issued books found for this student.";
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="StyleSheet.css" rel="Stylesheet" type="text/css" />
</head>

<body>
    <?php
    include("hedfoot/userbar.php");
    ?>

    <div class="table-container">
        <h2>IssueBook List</h2>

        <table class="styled-table" align="center">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Book Name</th>
                    <th>ISBN</th>
                    <th>Issue Date And Time</th>
                    <th>Return Date And Time</th>
                    <th>Fine</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $roll = $_SESSION['roll_no'];
                $cnt = 1;
                $sql1 = "SELECT addbooks.BookName, addbooks.ISBNNumber, issuedbook.IssuesDate, issuedbook.ReturnDate,issuedbook.fine
                        FROM issuedbook 
                        JOIN addbooks ON issuedbook.BookId = addbooks.id 
                        JOIN student ON issuedbook.roll_no = student.roll_no AND issuedbook.roll_no='$roll';";
                $result = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result) > 0) {
                    while ($value = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $cnt ?></td>
                            <td><?php echo htmlspecialchars($value['BookName']); ?></td>
                            <td><?php echo htmlspecialchars($value['ISBNNumber']); ?></td>
                            <td><?php echo htmlspecialchars($value['IssuesDate']); ?></td>
                            <td><?php if ($value['ReturnDate'] == "") {
                                    echo htmlentities("Not Return Yet");
                                } else {
                                    echo htmlentities($value['ReturnDate']);
                                } ?></td>
                            <td><?php if ($value['ReturnDate'] == "") {
                                    echo htmlentities("Not Return Yet");
                                } else {
                                    echo htmlentities($value['fine']);
                                } ?></td>
                        </tr>
                    <?php
                        $cnt++;
                    } ?>

                <?php
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>

            </tbody>

        </table>
        <center>
            <form method="post" action="uissuebook.php">
                <button type="submit" name="pdf" value="1" style="background-color: #2196F3; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; margin: 10px;">
                    DOWNLOAD YOUR BOOKS REPORT
                </button>
            </form>
        </center>

    </div>
    <br><br><br>
    <?php
    include("hedfoot/footer.php");
    ?>
</body>

</html>