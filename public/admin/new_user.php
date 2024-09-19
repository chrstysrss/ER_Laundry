<?php
    include_once ("../../src/php/db_connect.php");
    include('../../src/php/code_generator.php');

    if(!isset($_SESSION["username"]) || $_SESSION["role"] != "Manager"){
        header('location:../../public/index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>E&R Laundry</title>

    <link rel="stylesheet" href="../../src/css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../src/css/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../src/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/style-sidebar.css">
    <link rel="stylesheet" href="../../src/css/style-context.css">
    <script src="../../src/js/bootstrap/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
</head>
<body>
    <?php
        require_once("partials/_sidebar.php")
    ?>
    <div class="main-content">
        <div class="container bg-dark-blue rounded-border p-4 m-4">
            <h2 class="text-light text-center m-newUser">CREATE USER</h2>
            <div class="bg-light-gray rounded-border">
                <form id="newUser">
                    <div class="row">
                        <label class="col-auto">Username</label>
                        <div class="col-md-8">
                            <input type="text" disabled placeholder="<?php echo $alpha."-".$beta; ?>" required>
                            <input type="hidden" value="<?php echo $user_id; ?>" name="username" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row gx-1">
                        <div class="col-md-6">
                            <input type="text" placeholder="First Name" name="firstname" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" placeholder="Last Name" name="lastname" required>
                        </div>
                        
                        <input type="text" placeholder="Email" name="email" required>

                        <div class="col-md-6">
                            <input type="text" placeholder="Phone Number" name="phone" required>
                        </div>
                        <div class="col-md-6">
                            <select name="role" required>
                                <option value="" disabled selected hidden>Role</option>
                                <option value="Employee">Employee</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                        
                        <div class="input-password">
                            <input type="password" placeholder="Password" value="<?php echo $alpha."".$beta; ?>" name="password" required>
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="input-password">
                            <input type="password" placeholder="Confirm Password" name="confirmPass" required>
                            <i class="fas fa-eye"></i>
                        </div>

                        <input type="submit" class="col-auto btn btn-custom-2" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../src/js/password_visibility.js"></script>
    <script type="text/javascript" src="../../src/js/auth.js"></script>
</body>
</html>