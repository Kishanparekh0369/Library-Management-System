<?php

	$conn=mysqli_connect("localhost","root","","proj_libraryy");

	if(isset($_GET['del']))
	{
		$aid=$_GET['del'];
		$SQL="DELETE FROM `author` WHERE `aid`='$aid'";
		$result=mysqli_query($conn,$SQL);
		if(!$result)
		{
			echo "<script>alert('Error: Author Name Not Deleted '); window.location.href = 'manageauthor.php';</script>";
                exit();
		}
		else
		{
			echo "<script>alert('Author Name Deleted successfully'); window.location.href = 'manageauthor.php';</script>";
                exit();
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
    <h2>Author List</h2>
    
    <table class="styled-table" align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Author Name</th>
                <th>Registration Date And Time</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
        	<?php
        	$cnt=1;
        		$sql="SELECT * FROM `author`;";
        		$result=mysqli_query($conn,$sql);

        		if(mysqli_num_rows($result)>0)
        		{
        			foreach ($result as $value) { 

        	?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($value['author_name']); ?></td>
                <td><?php echo htmlspecialchars($value['reg_date']); ?></td>
                
                <td><center>
                    <a href="edit_author.php?edi=<?php echo htmlspecialchars($value['aid']);  ?>"><button class="btn edit">Edit</button></a>
                    <a href="manageauthor.php?del=<?php echo htmlspecialchars($value['aid']); ?>"><button class="btn delete">Delete</button></a></center>
                </td>
            </tr>
            <?php $cnt++; }} ?>
        </tbody>
    </table>
</div>
	<br><br><br>
	<?php
		include("hedfoot/footer.php");
	?>
</body>
</html>
