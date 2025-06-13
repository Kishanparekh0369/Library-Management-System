<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
     <link href="../StyleSheet.css" rel="Stylesheet" type="text/css" />

     <style>
 
        .modal {
            display: none; 
            position: fixed;
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            background-color: rgba(0, 0, 0, 0.4); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            text-align: center;
        }

        .modal button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }

        .modal .btn-yes {
            background-color: #4CAF50;
            color: white;
        }

        .modal .btn-no {
            background-color: #f44336;
            color: white;
        }
    </style>

    <script type="text/javascript">
       
        function showLogoutModal(event) {
            event.preventDefault(); 
            
           
            document.getElementById('logoutModal').style.display = 'block';
        }

    
        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

    
        function confirmLogout() {
        
            window.location.href = 'adminlog.php';
        }
    </script>
</head>
    <body>
        <div class="container">
            <ul>

                <li><a href="adminhome.php">DASHBOARD</a></li>

                <li>CATEGORIES
                    <div class="drop3">
                        <ul>
                            <li><a href="addcate.php">ADD CATEGORIE</a></li>
                            <li><a href="managecate.php">MANAGE CATEGORIES</a></li>
                        </ul>
                    </div>
                </li>

                <li>AUTHOR
                    <div class="drop3">
                        <ul>
                            <li><a href="add_author.php">ADD AUTHOR</a></li>
                            <li><a href="manageauthor.php">MANAGE AUTHOR</a></li>
                        </ul>
                    </div>

                <li>BOOKS
                    <div class="drop3">
                        <ul>
                            <li><a href="addbook.php">ADD BOOKS</a></li>
                            <li><a href="managebook.php">MANAGE BOOKS</a></li>
                        </ul>
                    </div>
                </li>

                <li>ISSUE BOOKS
                    <div class="drop3">
                        <ul>
                            <li><a href="issuebook.php">ISSUE NEW BOOK</a></li>
                            <li><a href="manageissuebook.php">MANAGE ISSUE BOOK</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="regstudent.php">REG STUDENTS</a></li>

                <li><a href="achangepassword.php">CHANGE PASSWORD</a></li>

              
            <li><a href="#" onclick="showLogoutModal(event)">LOGOUT</a></li>
        </ul>
    </div>

 
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h3>Are you sure you want to log out?</h3>
            <button class="btn-yes" onclick="confirmLogout()">Yes</button>
            <button class="btn-no" onclick="closeModal()">No</button>
        </div>
    </div>
            </ul>
            
        </div>
    <div class="header">
           <img src="banner-1544x500.jpg" alt="College Banner">

        </div>
            
    </body>
</html>