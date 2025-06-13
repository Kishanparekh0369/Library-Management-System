<html>
<head id="Head1" runat="server">
    <title></title>
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
        <form action="addcate.php" method="post" onsubmit="return validateForm()">
            <h2 align="center">Add Category</h2><br>

            <label for="category_name">Category Name</label>
            <input type="text" id="category_name" name="category_name">

            <div id="error-message" class="error" style="display:none;">Category is required and must only contain letters.</div>

            <br><button type="submit" name="cat">ADD categories</button>

            &nbsp;&nbsp;&nbsp;<label><small><a href="adminhome.php" for="align">BACK TO HOME</a></small></label>

        </form>
    </div><br><br><br>

    <?php
        include("hedfoot/footer.php");
    ?>

    <script>
        function validateForm() {
            var categoryName = document.getElementById("category_name").value;
            var errorMessage = document.getElementById("error-message");

           
            var regex = /^[A-Za-z\s]+$/; 
            if (categoryName === "") {
                errorMessage.textContent = "Category is required."; 
                errorMessage.style.display = "block"; 
                return false; 
            } else if (!regex.test(categoryName)) {
                errorMessage.textContent = "Category must only contain letters.";  
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

    if (isset($_POST['cat'])) {
        $catename = $_POST['category_name'];
        $c = $catename;

        $q = "SELECT `catename` FROM `category` WHERE `catename`='$c';";
        $r = mysqli_query($conn, $q);

        if (mysqli_num_rows($r) > 0) {
            echo "<script>alert('This category already exists'); window.location.href = 'adminhome.php';</script>";
            exit();
        } else {
            $sql = "INSERT INTO `category`(`catename`) VALUES ('$catename');";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "<script>alert('Error: Data not inserted'); window.location.href = 'addcate.php';</script>";
                exit();
            } else {
                echo "<script>alert('Data Inserted Successfully'); window.location.href = 'addcate.php';</script>";
                exit();
            }
        }
    }
?>
