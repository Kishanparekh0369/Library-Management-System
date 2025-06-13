<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Author</title>

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
            font-size: 12px;
        }
    </style>
</head>
<body>
	<?php
		include("adminbar.php");
	?>

	<div class="login">
        <form action="add_author.php" method="post" onsubmit="return validateForm()">
            <h2 align="center">ADD AUTHOR</h2><br>
            <label for="author_name">Author Name:</label>
            <input type="text" id="author_name" name="author_name">
            
           <br> <div id="error-message" class="error" style="display:none;">Author name is required and must only contain letters.</div> <br>            
            <button type="submit" id="align" name="add">ADD</button>

            &nbsp;&nbsp;&nbsp;<label><small><a href="adminhome.php" for="align">BACK TO HOME</a></small></label>
        </form>
    </div><br><br><br>

	<?php
		include("hedfoot/footer.php");
	?>

	<script>
        function validateForm() {
            var authorName = document.getElementById("author_name").value;
            var errorMessage = document.getElementById("error-message");

     
            var regex = /^[A-Za-z\s]+$/;
            
        
            if (authorName === "") {
                errorMessage.textContent = "Author name is required."; 
                errorMessage.style.display = "block"; 
                return false; 
            } else if (!regex.test(authorName)) {
                errorMessage.textContent = "Author name must only contain letters."; 
                errorMessage.style.display = "block"; 
                return false; 
            } else {
                errorMessage.style.display = "none"; 
                return true; 
            }
        }
    </script>
</body>
</html>

<?php
	$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");
    
    if(isset($_POST['add'])) {
        $authorname = $_POST['author_name'];

        $q = "SELECT * FROM `author` WHERE `author_name` = '$authorname';";
        $r = mysqli_query($conn, $q);

        if(mysqli_num_rows($r) > 0) {
            echo "<script>alert('This author already exists. Please try a different name.'); window.location.href = 'add_author.php';</script>";
            exit();
        } else {
            $sql = "INSERT INTO `author`(`author_name`) VALUES ('$authorname')";
            $result = mysqli_query($conn, $sql);

            if(!$result) {
                echo "<script>alert('Error: Data not inserted'); window.location.href = 'add_author.php';</script>";
                exit();
            } else {
                echo "<script>alert('Data Inserted Successfully'); window.location.href = 'add_author.php';</script>";
                exit();
            }
        }
    }
?>
