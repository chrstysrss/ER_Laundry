<?php
    include_once ("../../src/php/db_connect.php");

    if(!isset($_SESSION["username"]) || $_SESSION["role"] != "Manager"){
        header('location:../../public/index.php');
        exit();
    }


    $limit = 10; 
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    if (isset($_POST["submit"])) {
        $searchString = "%" . $_POST['search'] . "%";
        $countQuery = "SELECT COUNT(*) as total FROM employee WHERE CONCAT(employee_id, username, first_name, last_name, role) LIKE ? ORDER BY role DESC";
        $stmt = $con->prepare($countQuery);
        $stmt->bind_param("s", $searchString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalRecords = $row['total'];

        $query = "SELECT * FROM employee WHERE CONCAT(employee_id, username, first_name, last_name, role) LIKE ? LIMIT ?, ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $searchString, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $countQuery = "SELECT COUNT(*) as total FROM employee";
        $result = mysqli_query($con, $countQuery);
        $row = mysqli_fetch_assoc($result);
        $totalRecords = $row['total'];
        
        $query = "SELECT * FROM employee LIMIT ?, ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
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
        <link rel="stylesheet" href="../../src/css/style-tabular.css">
        <script src="../../src/js/bootstrap/bootstrap.js"></script>
    </head>
    <body>
        <?php
            require_once("partials/_sidebar.php")
        ?>
        <div class="main-content">
            <div class="container bg-dark-blue rounded-border p-3 m-4">
                <div class="row align-items-center">
                    <div class="col ps-3">
                        <h2 class="text-light m-0">USER LIST</h2>
                    </div>
                    <div class="col">
                        <a href="new_user.php" class="btn btn-custom-3 float-end py-1">
                            <i class="fa-solid fa-plus me-3"></i>Add New User
                        </a>
                    </div>
                </div>

                <div class="bg-light-gray rounded-border-15 my-3">
                    <form class="support-bar-2" action="" method="post">
                        <div class="input-search m-0">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search" id="title" name="search" autocomplete="off">
                        </div>
                        <button type="submit" name="submit" class="btn btn-custom-2">Search</button>
                    </form>
                </div>

                <div class="wrapper d-flex justify-content-between flex-column p-3">
                    <div class="table-responsive">
                        <table class="userTable">
                            <thead>
                                <tr> 
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th class="t-1"></th>
                                    <th class="t-10">Status</th>
                                    <th class="t-10"></th>
                                </tr>
                            </thead> 
                            <tbody>
                                    <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>  
                                     
                                <tr>
                                    <td><?php echo $row['employee_id']?></td>
                                    <td><?php echo $row['username']?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']?></td>
                                    <td><?php echo $row['role']?></td>
                                    <td></td>
                                    <?php   if ($row['username'] != "admin") {    ?> 

                                    <td>
                                        <?php   if ($row['status'] == 1) {    ?> 
                                            <button type="button" class="btn btn-success-light text-active" onclick="deactivateUser(<?php echo $row['employee_id']?>)">Active</button>
                                        <?php   } else {    ?>
                                            <button type="button" class="btn btn-primary-light text-inactive" onclick="activateUser(<?php echo $row['employee_id']?>)">Inactive</button>
                                        <?php   }   ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger text-delete" onclick="deleteUser(<?php echo $row['employee_id']?>)">Delete</button>
                                    </td>

                                    <?php   }    ?> 
                                </tr>

                                    <?php
                                        }
                                    mysqli_close($con);
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <?php   
                            require_once("../../src/php/pagination.php")   
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script>
        function deleteUser(deleteID){
            var text = "Confirm delete of User ID: "+deleteID+". Press OK to continue.";
            var totalPages = Math.ceil(<?php echo $totalRecords?> / <?php echo $limit?>);
            var records = <?php echo $totalRecords?>%<?php echo $limit?>;
            var page = <?php echo $page?>;
            var prev = page-1;

            if (confirm(text) == true){
                $.ajax({
                    url:"../../src/php/delete_user.php",
                    type:'post',
                    data:{deletesend:deleteID},
                    success: function(response){
                        var res = JSON.parse(response);
                        alert(res["message"]);
                        if(res["status"] == 200){
                            if(page == totalPages && records == 1 && page != 1){
                                window.location.replace("user_list.php?page="+prev);
                            } else{
                                location.reload(true);
                            }
                        }
                    }
                });
            }
        }


    // Activating user
    function activateUser(employeeID, button) {
        var text = "Confirm Activation of User ID: " + employeeID + ". Press OK to continue.";

        if (confirm(text)) {
            $.ajax({
                url: "../../src/php/set_active.php",
                type: "POST",
                data: { activeID: employeeID },
                success: function (response) {
                    var responseData = JSON.parse(response);
                    alert(responseData.message);
                    if (responseData.status === 200) {
                        window.location.reload();
                    }
                },
            });
        }
    }


    // Deactivating user
    function deactivateUser(employeeID, button) {
        var text = "Confirm Deactivation of User ID: " + employeeID + ". Press OK to continue.";

        if (confirm(text)) {
            $.ajax({
                url: "../../src/php/set_inactive.php",
                type: "POST",
                data: { inactiveID: employeeID },
                success: function (response) {
                    var responseData = JSON.parse(response);
                    alert(responseData.message);
                    if (responseData.status === 200) {
                        window.location.reload();
                    } 
                },
            });
        }
    }

    </script> 
</html>