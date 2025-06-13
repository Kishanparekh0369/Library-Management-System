<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

if (isset($_POST['up'])) {
    $aid = intval($_GET['edi']);
    $author_name = $_POST['author_name'];

    $SQL = "UPDATE `author` SET `author_name`='$author_name' WHERE `aid`='$aid';";
    $result = mysqli_query($conn, $SQL);
    if (!$result) {
        echo "<script>alert('Error: Author Name Not Updated'); window.location.href = 'edit_author.php';</script>";
        exit();
    } else {
        echo "<script>alert('Author Name updated successfully'); window.location.href = 'manageauthor.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Author</title>

    <link href="../StyleSheet.css" rel="stylesheet" type="text/css" />

    <script>
    
        function validateForm() {
            var authorName = document.getElementById("author_name").value;
            var errorMessage = document.getElementById("error-message");

           
            if (authorName == "") {
                errorMessage.innerHTML = "Field is required.";
                errorMessage.style.color = "red";
                errorMessage.style.fontWeight = "bold";
                return false;
            }

            
            else if (/\d/.test(authorName)) {
                errorMessage.innerHTML = "Only letters are allowed.";
                errorMessage.style.color = "red";
                errorMessage.style.fontWeight = "bold";
                return false;
            }

           
            errorMessage.innerHTML = "";
            return true;
        }
    </script>

</head>
<body>
    <?php
    include("adminbar.php");
    ?>

    <div class="login">
        <form role="form" method="post" onsubmit="return validateForm()">
            <h2 align="center">AUTHOR Info</h2><br>
            <label for="author_name">Author Name:</label>
            <?php
            $aid = intval($_GET['edi']);
            $sql = "SELECT * FROM `author` WHERE `aid`='$aid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                foreach ($result as $value) {
            ?>
            <input type="text" id="author_name" name="author_name" value="<?php echo htmlentities($value['author_name']); ?>">
            <?php }} ?>
            
          
           <br> <div id="error-message"></div><br>

            <button type="submit" id="align" name="up">UPDATE</button>
        </form>
    </div><br><br><br>

    <?php
    include("hedfoot/footer.php");
    ?>
</body>
</html>
