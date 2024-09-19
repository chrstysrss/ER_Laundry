<?php
    include_once ("../../src/php/db_connect.php");

    if(!isset($_SESSION["username"]) || $_SESSION["role"] != "Employee"){
        header('location:../../public/index.php');
        exit();
    }

    $order_id = $_GET['order_id'];
    $order_details_query = "SELECT * FROM orders JOIN employee ON orders.employee_id = employee.employee_id WHERE order_id = $order_id;";
    $order_details_result = mysqli_query($con, $order_details_query);

    $products_order_query = "SELECT * FROM order_details JOIN products ON order_details.product_id = products.product_id WHERE order_details.order_id = $order_id;";
    $products_order_result = mysqli_query($con, $products_order_query);
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
        <?php
                        if($row = mysqli_fetch_assoc($order_details_result))
                        {
                    ?>
        
        <div class="main-content">
            <div class="container bg-dark-blue rounded-border px-4 py-5 m-4">
                <div class="wrapper py-5">
                    <div class="support-bar mb-0">
                        <a href="orders.php" class="btn btn-primary">Go Back</a>
                        <button class="btn btn-success-light ms-2" onclick="printArea()"><i class="fa-solid fa-print"></i></button>
                    </div>
                    <h4 class="text-center fw-bold">Order Detail: <?php echo $row['order_id'] ?></h4>
                    <div class="row gx-1 bg-light mx-2 my-4 px-1 py-4 rounded-border">
                        <div class="col-lg-5 o-info" id="infoArea">
                            <h5 class="fw-bold mb-4">Order Information</h5>
                            <p>Order ID: <?php echo $row['order_id'] ?></p> 
                            <p>Date: <?php echo $row['date'] ?></p>
                            <p>Time: <?php echo $row['time'] ?></p>
                            <p>Customer Name: <?php echo $row['customer_firstname'] . " " . $row['customer_lastname'] ?></p>
                            <p>Customer Phone:  <?php echo $row['customer_phone'] ?></p>
                            <p>Laundry Attendant: <?php echo $row['first_name'] . " " . $row['last_name']?></p> 
                        </div>
                        <div class="col-lg-7 o-summary">
                            <h5 class="fw-bold mb-4">Order Summary</h5>
                            <div id="itemsArea">
                                <table class="o-items">
                                    <thead>
                                        <tr>
                                            <th>Items</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($line = mysqli_fetch_assoc($products_order_result))
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $line['product_name']?></td>
                                            <td><?php echo $line['price']?></td>
                                            <td><?php echo $line['quantity']?></td>
                                            <td><?php echo $line['total']?></td>
                                        </tr>
                                        <?php
                                            }}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="billArea">
                                <table class="o-bill">
                                    <tr>
                                        <td class="t-50">Discount</td>
                                        <td><?php echo $row['discount'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Grand Total</b></td>
                                        <td><?php echo $row['grand_total'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Amount Received</td>
                                        <td><?php echo $row['amount_received'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Change</td>
                                        <td><?php echo $row['amount_change'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="../../src/js/print.js"></script>
    </body>
</html>