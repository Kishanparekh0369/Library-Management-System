<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>USER BAR</title>
    <link href="StyleSheet.css" rel="Stylesheet" type="text/css" />
    
    <style>
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.4); /* Background overlay */
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
        // Function to show the modal
        function showLogoutModal(event) {
            event.preventDefault(); // Prevent the default link action
            
            // Show the modal
            document.getElementById('logoutModal').style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        // Function to confirm logout
        function confirmLogout() {
            // Redirect to logout page
            window.location.href = 'login.php';
        }
    </script>
</head>
<body>
    <div class="container">
        <ul>
            <li><a href="userdashborde.php">DASHBOARD</a></li>
            <li><a href="uissuebook.php">ISSUED BOOK</a></li>
            <li>PROFILE
                <div class="drop3">
                    <ul>
                        <li><a href="myprofile.php">MY PROFILE</a></li>
                        <li><a href="changepassword.php">CHANGE PASSWORD</a></li>
                    </ul>
                </div>
            </li>
            <!-- Logout button with custom modal trigger -->
            <li><a href="#" onclick="showLogoutModal(event)">LOGOUT</a></li>
        </ul>
    </div>

    <!-- Modal for confirmation -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h3>Are you sure you want to log out?</h3>
            <button class="btn-yes" onclick="confirmLogout()">Yes</button>
            <button class="btn-no" onclick="closeModal()">No</button>
        </div>
    </div>

    <div class="header">
        <img src="banner-1544x500.jpg" alt="College Banner">
    </div>
</body>
</html>
