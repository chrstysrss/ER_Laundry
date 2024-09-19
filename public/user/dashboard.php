<?php
    include_once ("../../src/php/db_connect.php");

    if(!isset($_SESSION["username"]) || $_SESSION["role"] != "Employee"){
        header('location:../../public/index.php');
        exit();
    }

    $user = $_SESSION["login_fname"]." ".$_SESSION["login_lname"];
    $user = strtoupper($user);

    $sql = "SELECT SUM(o.grand_total) AS total_sales FROM orders o WHERE date LIKE CURDATE()";
    $result = mysqli_query($con, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $total_sales = $row['total_sales'];
        if($total_sales == NULL){
            $total_sales = 0;
        }
    }


    $sql = "SELECT COUNT(date) AS orders_today FROM orders WHERE date LIKE CURDATE()";
    $result = mysqli_query($con, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $orders_today = $row['orders_today'];
    }

    $month = date('F');

    $sql = "SELECT customer_firstname, customer_lastname, SUM(grand_total) AS 'total_purchase' FROM orders WHERE customer_phone IS NOT NULL AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE()) GROUP BY customer_phone ORDER BY SUM(grand_total) DESC LIMIT 5";
    $result = mysqli_query($con, $sql);
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
    </head>
    <body>
        <?php
            require_once("partials/_sidebar.php")
        ?>
        <div class="main-content">
            <div class="container dashboard">
                <p class="text-light mt-3 ms-3">WELCOME USER <?php echo $user ?></p>
                <hr>
                <div class="row">

                    <div class="col dashboard-left">
                        <div class="card mb-5 bg-light-green">
                            <div class="card-body">
                                <p class="card-title">Total Sales Today</p>
                                <hr>
                                <p class="card-text"><?php echo $total_sales ?></p>
                            </div>
                        </div>
                        <div class="card bg-light-blue">
                            <div class="card-body">
                                <p class="card-title">Total Orders Today</p>
                                <hr>
                                <p class="card-text"><?php echo $orders_today ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col dashboard-right">
                        <div class="card bg-gray">
                            <div class="card-body">
                                <p class="card-title">Top 5 Customers (<?php echo $month ?>)</p>
                                <hr>
                                <p class="card-text">
                                    <?php
                                        while($row = mysqli_fetch_assoc($result)){
                                            $fname = $row['customer_firstname'];
                                            $lname = $row['customer_lastname'];
                                            echo "$fname $lname <br>";
                                        }
                                        echo "<br>";
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>