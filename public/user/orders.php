<?php
    include_once ("../../src/php/db_connect.php");

    if(!isset($_SESSION["username"]) || $_SESSION["role"] != "Employee"){
        header('location:../../public/index.php');
        exit();
    }

    
    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    
    if (isset($_POST["submit"])) {
        $searchString = "%" . $_POST['search'] . "%";
        $countQuery = "SELECT COUNT(*) as total FROM orders JOIN employee ON orders.employee_id = employee.employee_id WHERE CONCAT(order_id, date, customer_firstname, customer_lastname, customer_phone, grand_total, first_name, last_name) LIKE ? ORDER BY order_id DESC";
        $stmt = $con->prepare($countQuery);
        $stmt->bind_param("s", $searchString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalRecords = $row['total'];
    
        $query = "SELECT * FROM orders JOIN employee ON orders.employee_id = employee.employee_id WHERE CONCAT(order_id, date, customer_firstname, customer_lastname, customer_phone, grand_total, first_name, last_name) LIKE ? ORDER BY order_id DESC LIMIT ?, ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $searchString, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $countQuery = "SELECT COUNT(*) as total FROM orders ORDER BY order_id DESC";
        $result = mysqli_query($con, $countQuery);
        $row = mysqli_fetch_assoc($result);
        $totalRecords = $row['total'];
    
        $query = "SELECT * FROM orders JOIN employee ON orders.employee_id = employee.employee_id ORDER BY order_id DESC LIMIT ?, ?";
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
            <div class="container bg-dark-blue rounded-border px-4 py-5 m-4">
                <div class="support-bar">
                    <form class="row g-3" action="" method="post">
                        <div class="col-auto">
                            <label class="form-control-plaintext text-light">Search:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="title" name="search" autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="submit" class="btn btn-success-light">Search</button>
                        </div>
                    </form>
                </div>

                <div class="wrapper d-flex justify-content-between flex-column">
                    <table>
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th class="t-date">Date</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Total</th>
                                <th>Laundry Attendant</th>
                                <th class="t-btns"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                            
                                while ($row = mysqli_fetch_assoc($result)) {
                                
                                
                                ?>	
                                    <td><?php echo $row['order_id']?></td>
                                    <td><?php echo $row['date']?></td>
                                    <td><?php echo $row['customer_firstname'] . " " . $row['customer_lastname']?></td>
                                    <td><?php echo $row['customer_phone']?></td>
                                    <td><?php echo $row['grand_total']?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']?></td>
                                <td>
                                        <a href="details.php?order_id=<?php echo $row['order_id']; ?>"> 
                                            <button class="btn btn-primary me-1">Details</button>
                                        </a>
                                </tr>
                                    
                                <?php
                                    }
                                mysqli_close($con);
                                ?>
                            </tr>
                        </tbody>
                    </table>
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
</html>