<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

if (isset($_POST['pdf'])) {
    require_once __DIR__ . '/vendor/autoload.php';

   
    $sql = "SELECT student.f_name, student.roll_no, addbooks.BookName, addbooks.ISBNNumber, 
                   issuedbook.IssuesDate, issuedbook.ReturnDate,issuedbook.fine
            FROM issuedbook 
            JOIN student ON issuedbook.roll_no = student.roll_no 
            JOIN addbooks ON issuedbook.BookId = addbooks.id";

    $result = mysqli_query($conn, $sql);


    $html = "<h1 align='center' style='font-family: Arial, sans-serif; color: #333;'><u>Issued Books Report</u></h1><br><br>";


    $html .= "<table border='1' align='center' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
    $html .= "<tr style='background-color: #4CAF50; color: white;'>
                <th>NO</th>
                <th>Roll No</th>
                <th>Student Name</th>
                <th>Book Name</th>
                <th>ISBN</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Fine</th>
              </tr>";

    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $returnDate = ($row['ReturnDate'] == NULL || $row['ReturnDate'] == '') ? "Not Return Yet" : $row['ReturnDate'];
        $fine = ($row['ReturnDate'] == NULL || $row['ReturnDate'] == '') ? "Not Return Yet" : $row['fine'];
        $html .= "<tr>
                    <td>" . $count . "</td>
                    <td>" . htmlspecialchars($row['roll_no']) . "</td>
                    <td>" . htmlspecialchars($row['f_name']) . "</td>
                    <td>" . htmlspecialchars($row['BookName']) . "</td>
                    <td>" . htmlspecialchars($row['ISBNNumber']) . "</td>
                    <td>" . htmlspecialchars($row['IssuesDate']) . "</td>
                    <td>" . htmlspecialchars($returnDate) . "</td>
                    <td>" . htmlspecialchars($fine) . "</td>
                  </tr>";
        $count++;
    }

    $html .= "</table><br><br>";

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output("issued_books_report.pdf", "D");
    exit;
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="../StyleSheet.css" rel="Stylesheet" type="text/css" />
</head>

<body>
    <?php
    include("adminbar.php");
    ?>

    <div class="table-container">
        <h2>IssueBook List</h2>

        <table class="styled-table" align="center">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Student Name</th>
                    <th>Book Name</th>
                    <th>ISBN</th>
                    <th>Issue Date And Time</th>
                    <th>Return Date And Time</th>
                    <th>Fine</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $cnt = 1;
                $sql = "SELECT issuedbook.id, student.f_name, addbooks.BookName, addbooks.ISBNNumber, 
				        issuedbook.IssuesDate, issuedbook.ReturnDate,issuedbook.fine
				        FROM issuedbook 
				        JOIN addbooks ON issuedbook.BookId = addbooks.id 
				        JOIN student ON issuedbook.roll_no = student.roll_no;";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($value = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <td><?php echo $cnt ?></td>
                            <td><?php echo htmlspecialchars($value['f_name']); ?></td>
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

                            <td>
                                <center>
                                    <a href="edit_issuebook.php?edi=<?php echo htmlspecialchars($value['id']);  ?>"><button class="btn edit">Edit</button></a>

                            </td>
                        </tr>
                <?php
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <center>
            <form method="post" action="manageissuebook.php">
                <button type="submit" name="pdf" value="1" style="background-color: #2196F3; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; margin: 10px;">
                    DOWNLOAD ISSUEBOOKS LIST INFORMATION
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