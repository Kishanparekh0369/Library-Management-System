<?php
    $ae = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; 
    
    $conn = mysqli_connect("localhost", "root", "", "proj_libraryy");

    $errors = []; 
    $formData = []; 

    if (isset($_POST['ab'])) {
        $bt = $_POST['title']; 
        $aid = $_POST['author'];
        $pd = $_POST['year'];
        $cid = $_POST['category'];
        $ino = $_POST['isbn'];
        $pr = $_POST['price'];
        $file = $_FILES["image"];
        $imgname = $_FILES["image"]["name"];
        $tmpn = $_FILES['image']["tmp_name"];

        $formData = $_POST; 

  
        if (empty($bt)) {
            $errors['title'] = "Book title is required.";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $bt)) {
           
            $errors['title'] = "Book title should only contain alphabetic characters and spaces, no numbers or special characters.";
        } else {
           
            $sql = "SELECT id FROM addbooks WHERE BookName='$bt';";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                $errors['title'] = "Error: Book title already exists in the database.";
            }
        }

        if (empty($aid)) {
            $errors['author'] = "Author is required.";
        }

        if (empty($pd)) {
            $errors['year'] = "Date of publication is required.";
        }

        if (empty($cid)) {
            $errors['category'] = "Category is required.";
        }

        if (empty($ino)) {
            $errors['isbn'] = "ISBN number is required.";
        } else {
           
            if (!is_numeric($ino)) {
                $errors['isbn'] = "ISBN number must be numeric.";
            } else {
               
                $sql = "SELECT id FROM addbooks WHERE ISBNNumber='$ino';";
                $query = mysqli_query($conn, $sql);
                if (mysqli_num_rows($query) > 0) {
                    $errors['isbn'] = "Error: ISBN number is already taken. Please enter a new number.";
                }
            }
        }

        if (empty($pr)) {
            $errors['price'] = "Price is required.";
        } elseif (!is_numeric($pr)) {
            $errors['price'] = "Price must be a valid number.";
        }

        if (empty($file['name'])) {
            $errors['image'] = "Book cover image is required.";
        } else {
            $fe = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fe, $ae)) {
                $errors['image'] = "Invalid file type. Upload only jpg, jpeg, png.";
            }
            if ($file['size'] > $maxSize) {
                $errors['image'] = "Please upload a file of size 2MB or less.";
            }
        }

        if (empty($errors)) {
          
            $f = "image/" . $imgname;
            move_uploaded_file($tmpn, $f);

            $sql = "INSERT INTO `addbooks`(`BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `bookImage`, `pdate`) 
                    VALUES ('$bt', '$cid', '$aid', '$ino', '$pr', '$f', '$pd')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                $errors['general'] = "Error: Data not inserted.";
            } else {
                echo "<script>alert('Data inserted successfully'); window.location.href = 'addbook.php';</script>";
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library Management System - Add Book</title>
    <link href="../StyleSheet.css" rel="Stylesheet" type="text/css" />
    <style>
        .signup-form label,
        .signup-form button {
            display: inline-block;
            vertical-align: middle;
            gap: 30px;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>

    <script>

        function scrollToError() {
            const errors = document.querySelectorAll('.error');
            if (errors.length > 0) {
                errors[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }


        <?php if (!empty($errors)) { ?>
            document.addEventListener('DOMContentLoaded', function() {
                scrollToError();
            });
        <?php } ?>
    </script>
</head>
<body>
    <?php
        include("adminbar.php");
    ?>

    <div class="signup-form">
        <h2 align="center">Add a New Book</h2>
        <form action="addbook.php" method="POST" enctype="multipart/form-data">
            <br> 
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" value="<?= isset($formData['title']) ? htmlentities($formData['title']) : '' ?>">
            <?php if (isset($errors['title'])) { echo '<div class="error">' . $errors['title'] . '</div>'; } ?>

            <div class="form-group">
                <label for="author">Author:</label>
                <select id="author" name="author">
                    <option value="">Select Author</option>
                    <?php
                        $sql = "SELECT * FROM `author`;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $value) {
                                $selected = (isset($formData['author']) && $formData['author'] == $value['aid']) ? 'selected' : '';
                                echo "<option value='" . htmlentities($value['aid']) . "' $selected>" . htmlentities($value['author_name']) . "</option>";
                            }
                        }
                    ?>
                </select>
                <?php if (isset($errors['author'])) { echo '<div class="error">' . $errors['author'] . '</div>'; } ?>
            </div><br>

            <label for="year">Date of Publication:</label>
            <input type="date" id="year" name="year" value="<?= isset($formData['year']) ? htmlentities($formData['year']) : '' ?>" >
            <?php if (isset($errors['year'])) { echo '<div class="error">' . $errors['year'] . '</div>'; } ?>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">Select category</option>
                    <?php
                        $sql1 = "SELECT * FROM `category`;";
                        $result1 = mysqli_query($conn, $sql1);
                        if (mysqli_num_rows($result1) > 0) {
                            foreach ($result1 as $value1) {
                                $selected = (isset($formData['category']) && $formData['category'] == $value1['cid']) ? 'selected' : '';
                                echo "<option value='" . htmlentities($value1['cid']) . "' $selected>" . htmlentities($value1['catename']) . "</option>";
                            }
                        }
                    ?>
                </select>
                <?php if (isset($errors['category'])) { echo '<div class="error">' . $errors['category'] . '</div>'; } ?>
            </div>

            <br> 
            <label for="isbn">ISBN Number:</label>
            <input type="text" id="isbn" name="isbn" value="<?= isset($formData['isbn']) ? htmlentities($formData['isbn']) : '' ?>" >
            <?php if (isset($errors['isbn'])) { echo '<div class="error">' . $errors['isbn'] . '</div>'; } ?>

            <small><B><p>An ISBN is an International Standard Book Number. ISBN Must be unique.</p></B></small>

            <br> 
            <label for="Price">Price:</label>
            <input type="text" id="Price" name="price" value="<?= isset($formData['price']) ? htmlentities($formData['price']) : '' ?>" >
            <?php if (isset($errors['price'])) { echo '<div class="error">' . $errors['price'] . '</div>'; } ?>

            <br><label for="image">Upload Book Cover Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if (isset($errors['image'])) { echo '<div class="error">' . $errors['image'] . '</div>'; } ?>

            <button type="submit" name="ab">Add Book</button>
            &nbsp;&nbsp;&nbsp;<label><small><a href="adminhome.php" for="align">BACK TO HOME</a></small></label>
        </form>
    </div>

    <?php
        include("hedfoot/footer.php");
    ?>

</body>
</html>
