<?php

	$conn=mysqli_connect("localhost","root","","proj_libraryy");

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
    <h2>Book List</h2>
    
    <table class="styled-table" align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Book Name</th>
                <th>Catagory</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Registration Date</th>
                <th>Publition Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnt=1;
                $sql="SELECT addbooks.id, addbooks.BookName, category.catename, author.author_name, addbooks.ISBNNumber, addbooks.BookPrice, addbooks.bookImage, addbooks.RegDate, addbooks.pdate FROM addbooks join author on author.aid=addbooks.AuthorId join category on category.cid=addbooks.CatId";
                $result=mysqli_query($conn,$sql);

                if(mysqli_num_rows($result)>0)
                {
                    foreach ($result as $value) 
                    { 

            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td width="300px">
                    <img src="<?php echo "admin/".htmlspecialchars($value['bookImage']); ?>" width="100px"><br>
                    <b><?php echo htmlspecialchars($value['BookName']); ?></b>
                </td>
                <td><?php echo htmlspecialchars($value['catename']); ?></td>
                <td><?php echo htmlspecialchars($value['author_name']); ?></td>
                <td><?php echo htmlspecialchars($value['ISBNNumber']); ?></td>
                <td><?php echo htmlspecialchars($value['BookPrice']); ?></td>
                <td><?php echo htmlspecialchars($value['RegDate']); ?></td>
                <td><?php echo htmlspecialchars($value['pdate']); ?></td>
                
            </tr>
            <?php $cnt++; }} ?>
        </tbody>
    </table>
</div>
    <br><br><br><br>
    <?php
        include("hedfoot/footer.php");
    ?>
</body>
</html>
