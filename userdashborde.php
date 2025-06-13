<?php
session_start();


if (!isset($_SESSION['roll_no'])) {

    header('Location: login.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "proj_libraryy");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>

    <link href="StyleSheet.css" rel="Stylesheet" type="text/css" />
    <style>
       
        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            text-align: center;
        }

        .dashboard h1 {
            margin-bottom: 30px;
            font-size: 2em;
            color: #444;
        }

        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 200px;
            cursor: pointer;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .card h2 {
            font-size: 2rem;
            margin: 10px 0;
        }

        .card p {
            font-size: 1.1rem;
            color: #555;
        }

        .card.green {
            border: 2px solid #5cb85c;
            color: #5cb85c;
        }

        .card.brown {
            border: 2px solid #8b572a;
            color: #8b572a;
        }

        .card.red {
            border: 2px solid #d9534f;
            color: #d9534f;
        }

        .card.blue {
            border: 2px solid #0275d8;
            color: #0275d8;
        }

        .card a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <?php
    include("hedfoot/userbar.php"); 
    ?>

    <div class="dashboard">
        <h1>USER DASHBOARD</h1>
        <div class="dashboard-cards">
         
            <div class="card green">
                <a href="book_listed.php"></a>
                <div class="card-icon">
                    &#128218; 
                </div>
                <?php
                    $sql = "SELECT * FROM `addbooks`;";
                    $re = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($re);
                ?>
                <h2><?php echo htmlspecialchars($count); ?></h2>
                <p>Books Listed</p>
            </div>

          
            <div class="card brown">
                <div class="card-icon">
                    ♻️ 
                </div>
                <?php
                    $roll_no = $_SESSION['roll_no']; 
        
                    $sql2 = "SELECT COUNT(*) as total FROM `issuedbook` WHERE `ReturnDate` is NULL AND `RetrunStatus`=0 AND `roll_no`='$roll_no';";
                    $re2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_fetch_assoc($re2);
                
                ?>
                <h2><?php echo htmlspecialchars($count2["total"]); ?></h2>
                <p>Books Not Returned Yet</p>
            </div>

            <div class="card green">
                <a href="uissuebook.php"></a>
                <div class="card-icon">
                    &#128218; 
                </div>
                <?php 
                    $sql6 = "SELECT * FROM `issuedbook` WHERE `roll_no` = '$roll_no';";
                    $re6 = mysqli_query($conn, $sql6);
                    $count6 = mysqli_num_rows($re6);
                ?>
                <h2><?php echo htmlspecialchars($count6); ?></h2>
                <p>Issued Books</p>
            </div>
        </div>
    </div>

    <br><br><br><br>

    <?php
    include("hedfoot/footer.php"); 
    ?>
</body>
</html>
