<?php
    session_start();
    if(isset($_SESSION["username"])){
        if($_SESSION['role'] == "Employee"){
            header("Location:user/dashboard.php");
        } else{
            header("Location:admin/dashboard.php");
        }
        
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="../src/css/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="../src/css/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="../src/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../src/css/style-index.css">
        <script src="../src/js/bootstrap/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <title>E&R Laundry</title>
    </head>
    <body>
        <div class="banner">
            <div class="overlay">
            </div>
            <div class="wrapper d-flex justify-content-center align-items-center">

                <form id="signinForm">
                    <h1>Login</h1>
                    <input type="text" placeholder="Username" name="username" required>
                    <div class="input-password">
                        <input type="password" placeholder="Password" name="password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <input type="submit" value="LOGIN">
                </form>

            </div>
        </div>
        <script type="text/javascript" src="../src/js/password_visibility.js"></script>
        <script type="text/javascript" src="../src/js/auth.js"></script>
    </body>
</html>