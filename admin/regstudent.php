<?php
require_once __DIR__ . '/vendor/autoload.php'; 

$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");


if (isset($_POST['pdf'])) {

	$sql1 = "SELECT f_name, roll_no, email_id, m_no, gender, field, reg_date,img FROM student";
	$result1 = mysqli_query($conn, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		$html = "";

	
		$html .= "<h1 align='center' style='font-family: Arial, sans-serif; color: #333;'><u>Registered Students List</u></h1><br><br>";

		$html .= "<table border='1' align='center' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>";
		$html .= "<tr style='background-color: #4CAF50; color: white;'>
                    <th>NO</th>
										<th>Photo</th>
                    <th>Roll No</th>
										<th>Student Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Gender</th>
                    <th>Field</th>
                    <th>Register Date</th>
                  </tr>";

		$count = 1;
		while ($row = mysqli_fetch_assoc($result1)) {
			$imgPath = "../".$row['img'];
			$imageTag = "<img src='$imgPath' width='100' style='border-radius: 5px;'>"; 
			$html .= "<tr>
                        <td>" . $count . "</td>
												<td>" . $imageTag . "</td>
                        <td>" . htmlspecialchars($row['roll_no']) . "</td>
												<td>" . htmlspecialchars($row['f_name']) . "</td>
                        <td>" . htmlspecialchars($row['email_id']) . "</td>
                        <td>" . htmlspecialchars($row['m_no']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['field']) . "</td>
                        <td>" . htmlspecialchars($row['reg_date']) . "</td>
                      </tr>";
			$count++;
		}
		$html .= "</table><br><br>";

		
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output("registered_students.pdf", "D"); 
	} else {
		echo "No student records found.";
	}
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
		<h2>Register Student</h2>

		<table class="styled-table">
			<thead>
				<tr>
					<th>NO</th>
					<th>Student Roll Number</th>
					<th>Student Name</th>
					<th>Email Id</th>
					<th>Mobile number</th>
					<th>Gender</th>
					<th>Field</th>
					<th>Reg Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$cnt = 1;
				$sql = "SELECT * FROM `student`";
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
					foreach ($result as $value) {
				?>
						<tr>
							<td><?php echo $cnt; ?></td>
							<td><?php echo htmlspecialchars($value['roll_no']); ?></td>
							<td><?php echo htmlspecialchars($value['f_name']); ?></td>
							<td><?php echo htmlspecialchars($value['email_id']); ?></td>
							<td><?php echo htmlspecialchars($value['m_no']); ?></td>
							<td><?php echo htmlspecialchars($value['gender']); ?></td>
							<td><?php echo htmlspecialchars($value['field']); ?></td>
							<td><?php echo htmlspecialchars($value['reg_date']); ?></td>
						</tr>
				<?php $cnt++;
					}
				} ?>
			</tbody>
		</table>
		<center>
			<form method="post" action="regstudent.php">
				<button type="submit" name="pdf" value="1" style="background-color: #2196F3; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; margin: 10px;">
				DOWNLOAD REGISTER STUDENT INFORMATION	
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