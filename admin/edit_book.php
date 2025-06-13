<?php
    $conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

    if (isset($_POST['updatese'])) {
        $id = intval($_GET['edi']);
        $tital = $_POST['title'];
        $cate = $_POST['catagory'];
        $author = $_POST['author'];
        $price = $_POST['price'];
        $isbn = $_POST['isbn'];

        $sql0 = "UPDATE `addbooks` SET `BookName`='$tital',`CatId`='$cate',`AuthorId`='$author',`BookPrice`='$price', `ISBNNumber`='$isbn' WHERE `id`='$id';";
        $result0 = mysqli_query($conn, $sql0);

        if (!$result0) {
            echo "<script>alert('Error: Book Not Updated'); window.location.href = 'edit_book.php';</script>";
            exit();
        } else {
            echo "<script>alert('Book updated successfully'); window.location.href = 'managebook.php';</script>";
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library Management System - Edit Book</title>
    <link href="../StyleSheet.css" rel="stylesheet" type="text/css" />
    
    <style>
        .signup-form label,
        .signup-form button {
            display: inline-block;
            vertical-align: middle;
            gap: 30px;
        }
        
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>

    <script>
       
        function validateForm() {
            var title = document.getElementById("title").value;
            var isbn = document.getElementById("isbn").value;
            var price = document.getElementById("Price").value;

            var titleError = document.getElementById("title-error");
            var isbnError = document.getElementById("isbn-error");
            var priceError = document.getElementById("price-error");

     
            titleError.innerHTML = "";
            isbnError.innerHTML = "";
            priceError.innerHTML = "";

            var valid = true;

          
            if (title == "") {
                titleError.innerHTML = "Book Title is required.";
                valid = false;
            } else if (/\d/.test(title)) {
                titleError.innerHTML = "Book Title should only contain letters.";
                valid = false;
            }

         
            if (isbn == "") {
                isbnError.innerHTML = "ISBN Number is required.";
                valid = false;
            } else if (isNaN(isbn)) {
                isbnError.innerHTML = "ISBN Number should only contain numbers.";
                valid = false;
            }

          
            if (price == "") {
                priceError.innerHTML = "Price is required.";
                valid = false;
            } else if (isNaN(price)) {
                priceError.innerHTML = "Price should only contain numbers.";
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>
    <?php
        include("adminbar.php");
    ?>

    <div class="signup-form">
        <h2 align="center">Edit Book</h2>
        <form role="form" method="POST" onsubmit="return validateForm()">
            <?php
                $bookid = intval($_GET['edi']);
                $sql = "SELECT addbooks.id, addbooks.BookName, category.catename, category.cid, author.author_name, author.aid, addbooks.ISBNNumber, addbooks.BookPrice, addbooks.bookImage FROM addbooks JOIN author ON author.aid = addbooks.AuthorId JOIN category ON category.cid = addbooks.CatId WHERE addbooks.id='$bookid'";
                $results = mysqli_query($conn, $sql);
                if (mysqli_num_rows($results) > 0) {
                    foreach ($results as $result) {
            ?>
            <br> <label for="image">Book Image:</label>
            <img src="<?php echo htmlentities($result['bookImage']); ?>" width="100px"><br>

            <br> <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlentities($result['BookName']); ?>">
            <div id="title-error" class="error-message"></div><br>

            <div class="form-group">
                <label for="catagory">Category</label>
                <select class="form-control" name="catagory" required="required">
                    <option value="<?php echo htmlentities($result['cid']);?>">
                        <?php echo htmlentities($catname = $result['catename']); ?>
                    </option>
                    <?php
                    $sql1 = "SELECT * FROM category;";
                    $query1 = mysqli_query($conn, $sql1);
                    if (mysqli_num_rows($query1) > 0) {
                        foreach ($query1 as $row) {
                            if ($catname == $row['catename']) {
                                continue;
                            } else {
                    ?>
                    <option value="<?php echo htmlentities($row['cid']); ?>">
                        <?php echo htmlentities($row['catename']); ?>
                    </option>
                    <?php }}} ?>
                </select>
            </div><br>

            <div class="form-group">
                <label for="author">Author</label>
                <select class="form-control" name="author" required="required">
                    <option value="<?php echo htmlentities($result['aid']);?>">
                        <?php echo htmlentities($author_name = $result['author_name']); ?>
                    </option>
                    <?php
                    $sql2 = "SELECT * FROM author;";
                    $query2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($query2) > 0) {
                        foreach ($query2 as $rows) {
                            if ($author_name == $rows['author_name']) {
                                continue;
                            } else {
                    ?>
                    <option value="<?php echo htmlentities($rows['aid']); ?>">
                        <?php echo htmlentities($rows['author_name']); ?>
                    </option>
                    <?php }}} ?>
                </select>
            </div>

            <br> <label for="isbn">ISBN Number:</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlentities($result['ISBNNumber']); ?>">
            <div id="isbn-error" class="error-message"></div><br>
            <small><B><p>An ISBN is an International Standard Book Number. ISBN must be unique.</p></B></small>

            <br> <label for="Price">Price:</label>
            <input type="text" id="Price" name="price" value="<?php echo htmlentities($result['BookPrice']); ?>">
            <div id="price-error" class="error-message"></div><br>

            <?php }} ?>

            <button type="submit" name="updatese">Update Book</button>

        </form>
    </div>

    <?php
        include("hedfoot/footer.php");
    ?>

</body>
</html>
