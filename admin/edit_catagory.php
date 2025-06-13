<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

if (isset($_POST['update'])) {
    $cid = intval($_GET['edi']);
    $catename = $_POST['catename'];

    $SQL = "UPDATE `category` SET `catename`='$catename' WHERE `cid`='$cid';";
    $result = mysqli_query($conn, $SQL);
    if (!$result) {
        echo "<script>alert('Error: Category Name Not Updated'); window.location.href = 'edit_category.php';</script>";
        exit();
    } else {
        echo "<script>alert('Category Name updated successfully'); window.location.href = 'managecate.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Category</title>

    <link href="../StyleSheet.css" rel="stylesheet" type="text/css" />

    <script>
 
        function validateForm() {
            var catename = document.getElementById("catename").value;
            var errorMessage = document.getElementById("error-message");
            
            if (catename == "") {
                errorMessage.innerHTML = "Category Name is required.";
                errorMessage.style.color = "red";
                errorMessage.style.fontWeight = "bold";
                return false;
            } else if (/\d/.test(catename)) {
                errorMessage.innerHTML = "Category Name should only contain letters.";
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
            <h2 align="center">Category Info</h2><br>
            <label for="catename">Category Name:</label>
            <?php 
            $cid = intval($_GET['edi']);
            $sql = "SELECT * FROM `category` WHERE `cid`='$cid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                foreach ($result as $value) {
            ?>
            <input type="text" id="catename" name="catename" value="<?php echo htmlentities($value['catename']); ?>">
            <?php }} ?>
            
           
            <br><div id="error-message"></div><br>

            <button type="submit" id="align" name="update">UPDATE</button>
        </form>
    </div><br><br><br>

    <?php
    include("hedfoot/footer.php");
    ?>
</body>
</html>
