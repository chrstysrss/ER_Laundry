<?php
    include_once ("../../src/php/db_connect.php");

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
    <link rel="stylesheet" href="../../src/css/style-pos.css">
    <script src="../../src/js/bootstrap/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
    <?php
        require_once("partials/_sidebar.php")
    ?>
    <div class="main-content">
        <form id="process-laundry">
            <div class="container py-4">
                <div class="row rounded-border bg-dark-blue shadow">
                    <div class="col-lg-8 p-4">
                        <h2 class="text-light">NEW ORDER</h2>
                        <div class="details">
                            <h2 class="text-light">CUSTOMER DETAILS</h2>
                            <div class="d-flex justify-content-center mb-3">
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" autocomplete="off">
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" autocomplete="off">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" autocomplete="off">
                            </div>
                        </div>

                        <!-- SERVICES -->
                        <div class="services">
                            <h2 class="text-light">SERVICES</h2>
                            <div class="d-flex justify-content-center">

                            <?php 
                                $sql = "SELECT product_name, product_type, price FROM `products` WHERE product_type = 'Service'";
                                $result = mysqli_query($con, $sql);

                                while($row = mysqli_fetch_assoc($result)){
                                    if($row['product_type'] == "Service"){
                                        if($row['product_name'] == "Wash"){
                            ?>

                            <button type="button" class="btn btn-primary-light" id="add_wash" value="<?php echo $row['price'] ?>">Wash</button>
                                <?php } else if($row['product_name'] == "Dry"){ ?>
                            <button type="button" class="btn btn-success-light" id="add_dry" value="<?php echo $row['price'] ?>">Dry</button>
                                <?php } else if($row['product_name'] == "Drop-off"){ ?>
                            <button type="button" class="btn btn-warning text-light" id="add_dropoff" value="<?php echo $row['price'] ?>">Drop-off</button>
                                <?php }}}?>

                            </div>
                        </div>
                        
                        <!-- PRODUCTS -->
                        <div class="products">
                            <h2 class="text-light">CONSUMABLES</h2>
                            <div class="d-flex">
                                <select class="form-select mx-5" id="consumables">
                                <?php           
                                    $sql = "SELECT product_id, product_name, price, stock FROM `products` WHERE product_type = 'Consumables'";
                                    $result = mysqli_query($con, $sql);
            
                                    while($row = mysqli_fetch_assoc($result)){
                                        $id = $row['product_id'];
                                        $name = $row['product_name'];
                                        $price = $row['price'];
                                        $stock = $row['stock'];
                                        
                                        if($stock > 0){
                                ?>
                                    <option value="<?php echo $id ?>" data-price="<?php echo $price ?>" data-stock="<?php echo $stock ?>"><?php echo $name ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-custom" id="add_consumable">Add</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 bg-gray rounded-border">
                        <div class="cart rounded-border">
                            <table id="product_list">
                                <thead>
                                    <tr>
                                        <th class="t-50">Items</th>
                                        <th class="t-10">Price</th>
                                        <th class="t-10">Qty</th>
                                        <th class="border-end-0 t-30">Total</th>
                                        <th class="t-10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="bill">
                                <h3>Grand Total:<span id="tamount">0.00</span></h3>
                                <div class="row justify-content-md-center discount">
                                    <label class="col-auto col-form-label">Discount:</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="discount" name="discount" value="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gray-buttons">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Confirm</button>
                            <button type="button" class="btn btn-dark" id="resetbtn">Reset</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade bg-darkblue-subtle" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Payment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <h4 class="text-center">Grand Total: <input type="hidden" name="grandtotal" value="0"><span id="tamount1">0.00</span></h4>
                                <label class="form-control-plaintext">Payment Received</label>
                                <div class="col-auto">
                                    <input type="text" class="form-control" name="received" value="0" autocomplete="off">
                                </div>
                                <p>Change: <input type="hidden" name="amount_change" value="0"><span class="ps-2" id="amount_change">0.00</span></p>
                        </div>
                        <div class="modal-footer">
                            <a href="transaction.php">
                                <button class="btn btn-success-light text-dark">Submit</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="../../src/js/pos.js"></script>
</body>
</html>