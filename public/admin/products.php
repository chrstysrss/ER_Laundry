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
        $countQuery = "SELECT COUNT(*) as total FROM products WHERE CONCAT(product_id, product_name) LIKE ?";
        $stmt = $con->prepare($countQuery);
        $stmt->bind_param("s", $searchString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalRecords = $row['total'];

        $query = "SELECT * FROM products WHERE CONCAT(product_id, product_name) LIKE ? LIMIT ?, ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $searchString, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $countQuery = "SELECT COUNT(*) as total FROM products";
        $result = mysqli_query($con, $countQuery);
        $row = mysqli_fetch_assoc($result);
        $totalRecords = $row['total'];
        
        $query = "SELECT * FROM products LIMIT ?, ?";
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
                <div class="support-bar row justify-content-between">
                    <form class="row" style="width: 70%;" action="" method="post">
                        <div class="col-auto">
                            <label class="form-control-plaintext text-light">Search:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="title" name="search" autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                    <button type="button" style="width: 165px; height: 38px;" class="btn btn-success-light text-black" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-plus me-3"></i>Add Product
                    </button>
                </div>

                <div class="wrapper d-flex justify-content-between flex-column">
                    <table class="">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock Available</th>
                                <th class="t-btns"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                ?>
                                <td><?php echo $row['product_id']?></td>
                                <td><?php echo $row['product_name']?></td>
                                <td>₱ <?php echo $row['price']?></td>
                                <td>
                                    <?php 
                                        if($row['stock'] <= 0){
                                            echo "-";
                                        } else {
                                            echo $row['stock'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="getProduct(<?php echo $row['product_id']?>)" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                                    <?php if($row['product_type'] == "Consumables"){ ?>
                                        <button type="button" class="btn btn-danger" onclick="deleteProduct(<?php echo $row['product_id']?>)">Delete</button>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php
                                    }
                                mysqli_close($con);
                                ?>
                    </table>
                    <div class="pagination">
                        <?php   
                            require_once("../../src/php/pagination.php")   
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADD PRODUCT MODAL -->  
        <div class="modal fade bg-darkblue-subtle" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">New Product Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-4">

                        <div class="form-group my-3">
							<label for="product_name_add">Product Name</label>
							<input type="text" name="product_name_add" class="form-control" id="product_name_add" autocomplete="off" placeholder="Enter product name">
							<span id="pna_error" style="color: red; font-size: 10px;"></span>
						</div>
						
						<div class="form-group my-3">
							<label for="description_add">Description</label>
							<textarea name="description_add" class="form-control" id="description_add" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group my-3">
							<label for="price_add">Price</label>
							<input type="number" name="price_add" class="form-control" id="price_add" placeholder="Enter product price">
							<span id="ppa_error" style="color: red; font-size: 10px;"></span>
						</div>
						
						<div class="form-group my-3">
							<label for="stock_add">Stock</label>
							<input type="number" name="stock_add" class="form-control" id="stock_add">
						</div>
                        
                    </div>
                    <div class="modal-footer">
                        <button  onclick="addProduct()" type="button" name="addProduct" class="btn btn-success-light text-dark">Add Product</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE PRODUCT MODAL -->  
        <div class="modal fade bg-darkblue-subtle" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateModalLabel">Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-4">

                        <div class="form-group my-3">
							<label for="product_name">Product Name</label>
							<input type="text" name="product_name" class="form-control" id="product_name" autocomplete="off" placeholder="Enter product name">
							<span id="pnu_error" style="color: red; font-size: 10px;"></span>
						</div>
						
						<div class="form-group my-3">
							<label for="description">Description</label>
							<textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
						</div>
						
						<div class="form-group my-3">
							<label for="price">Price</label>
							<input type="number" name="price" class="form-control" id="price" placeholder="Enter product price">
							<span id="ppu_error" style="color: red; font-size: 10px;"></span>
						</div>
						
						<div class="form-group my-3">
							<label for="stock">Stock</label>
							<input type="number" name="stock" class="form-control" id="stock">
                            <input type="hidden" id="servicesData">
						</div>
                        
                    </div>
                    <div class="modal-footer">
                        <button  onclick="updateProduct()" type="button" name="editProduct" class="btn btn-success-light text-dark">Submit</button>
						<input type="hidden" id="hiddenData">
                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../../src/js/products.js"></script>
    <script>
        function deleteProduct(deleteID){
            var text = "Confirm delete of Product ID: "+deleteID+". Press OK to continue.";
            var totalPages = Math.ceil(<?php echo $totalRecords?> / <?php echo $limit?>);
            var records = <?php echo $totalRecords?>%<?php echo $limit?>;
            var page = <?php echo $page?>;
            var prev = page-1;

            if (confirm(text) == true){
                $.ajax({
                    url:"../../src/php/product_delete.php",
                    type:'post',
                    data:{deletesend:deleteID},
                    success:function(data, status){
                        if(page == totalPages && records == 1 && page != 1){
                            window.location.replace("products.php?page="+prev);
                        } else{
                            location.reload(true);
                        }
                    }
                });
            }
        }
    </script>
</html>
