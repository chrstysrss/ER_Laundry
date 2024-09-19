<?php
    include_once ("../../src/php/db_connect.php");

    if(!isset($_SESSION["login_email"])) {
        header('location:../../public/index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="../../src/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../../src/css/style-hf.css">
        <link rel="stylesheet" href="../../src/css/style-pos.css">
        <script src="../../src/js/bootstrap/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        
        <title>E&R Laundry</title>
    </head>
    <body>
        <header>
            <a href="dashboard.php" class="header-logo">E&R Laundry</a>
        </header>

        <div class="container my-5">
        <form id="process-laundry" >   <!-- method="POST" action="save_order.php" -->
            <div class="row mb-5">
                <div class="col-md-8 bg-white p-4">
                    <div class="icon-return">
                        <a href="dashboard.php">
                            <span class="material-symbols-outlined">reply</span>
                        </a>
                    </div>
                    <h1>New Order</h1>
                    <div class="details">
                        <h2>Customer Details</h2>
                        <div class="d-flex">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" autocomplete="off">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" autocomplete="off">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" autocomplete="off">
                        </div>
                    </div>

                    <div class="services">
                        <h2>Services</h2>
                        <div class="d-flex justify-content-center">
            <?php 
                        $sql = "SELECT product_name, product_type, price FROM `products` WHERE product_type = 'Service'";
                        $result = mysqli_query($con, $sql);

                        while($row = mysqli_fetch_assoc($result)){
                            if($row['product_type'] == "Service"){
                                if($row['product_name'] == "Wash"){
            ?>
                            <button type="button" class="btn btn-primary" id="add_wash" value="<?php echo $row['price'] ?>">Wash</button>
            <?php               } else if($row['product_name'] == "Dry"){ ?>
                            <button type="button" class="btn btn-success" id="add_dry" value="<?php echo $row['price'] ?>">Dry</button>
            <?php               } else if($row['product_name'] == "Drop-off"){ ?>
                            <button type="button" class="btn btn-warning text-light" id="add_dropoff" value="<?php echo $row['price'] ?>">Drop-off</button>
             <?php      }}}?>
                        </div>
                    </div>
                    <div class="products">
                        <h2>Consumables</h2>
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
            <?php           } }?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-custom" id="add_consumable">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 bg-gray">
                    <div class="cart">
                        <table id="product_list">
                            <thead>
                                <tr>
                                    <th>Items</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="border-end-0 t-20">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="bill">
                            <h3>Grand Total: <span id="tamount">0.00</span></h3>
                            <div class="discount">
                                <div class="col-auto">
                                    <label class="form-control-plaintext">Discount:</label>
                                </div>
                                <div class="col-auto">
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


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Go Back</button>
                        <a href="transaction.php">
                            <button class="btn btn-success">Submit</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

        <script type="text/javascript">

            $('#add_wash').click(function(){
                addService("Wash", $('#add_wash').attr("value"), "1");
                $('#add_wash').attr('disabled', true);
            })

            $('#add_dry').click(function(){
                addService("Dry", $('#add_dry').attr("value"), "2");
                $('#add_dry').attr('disabled', true);
            })

            $('#add_dropoff').click(function(){
                addService("Drop-off", $('#add_dropoff').attr("value"), "3");
                $('#add_dropoff').attr('disabled', true);
            })


            function addService(name, price, pid){
                var tr = $('<tr></tr>');
                tr.attr('data-id', pid)
                tr.append('<td><input type="hidden" name="prod_id[]" value="'+pid+'">'+name+'</td>');
                tr.append('<td><input type="hidden" name="prod_price[]" value="'+price+'">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</td>');
                tr.append('<td class="text-center px-2"><input type="number" name="prod_qty[]" min="1" value="1"></td>');
                tr.append('<td class="t-20"><input type="hidden" name="prod_total[]" value="'+price+'"><p class="m-0">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</p></td>');
                tr.append('<td class="text-center p-0 pe-2"><div class="d-flex justify-content-between"><span class="material-symbols-outlined" onclick="delete_list($(this))">delete</span></div></td>');

                $('#product_list').append(tr)
                calc()

                $('[name="prod_qty[]"]').on('keyup keydown keypress change',function(){
                    calc();
                })
            }


            $('#add_consumable').click(function(){
                var prod = $('#consumables :selected').val();

                if($('#product_list tr[data-id="'+prod+'"]').length > 0){
                    alert('Consumable already exists.','warning')
                    return false;
                }

                var pname = $('#consumables option[value="'+prod+'"]').text();
                var price = $('#consumables option[value="'+prod+'"]').attr('data-price');
                var stock = $('#consumables option[value="'+prod+'"]').attr('data-stock');
 
                var tr = $('<tr></tr>');
                tr.attr('data-id',prod)
                tr.append('<td><input type="hidden" name="prod_id[]" value="'+prod+'">'+pname+'</td>');
                tr.append('<td><input type="hidden" name="prod_price[]" value="'+price+'">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</td>');
                tr.append('<td class="text-center px-2"><input type="number" name="prod_qty[]" min="1" max="'+stock+'" value="1"></td>');
                tr.append('<td class="t-20"><input type="hidden" name="prod_total[]" value="'+price+'"><p class="m-0">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</p></td>');
                tr.append('<td class="text-center p-0 pe-2"><div class="d-flex justify-content-between"><span class="material-symbols-outlined" onclick="delete_list($(this))">delete</span></div></td>');

                $('#product_list').append(tr)
                $('#consumables option[value="'+prod+'"]').attr('disabled', true);
                calc()

                $('[name="prod_qty[]"]').on('keyup keydown keypress change',function(){
                    calc();
                })
            })
            
            
            function delete_list(_this){
                var pid = _this.closest('tr').attr('data-id');
                _this.closest('tr').remove()

                switch(pid){
                    case "1":
                        $('#add_wash').attr('disabled', false);
                        break;
                    case "2":
                        $('#add_dry').attr('disabled', false);
                        break;
                    case "3":
                        $('#add_dropoff').attr('disabled', false);
                        break;
                    default:
                        $('#consumables option[value="'+pid+'"]').attr('disabled', false);
                }

                calc()
                //     $('[name="tendered"]').trigger('keypress')
            }


            $('#discount').change(function(){
                calc()
            })


            function calc(){
                var grandtotal = 0;
                var discount = $('[name="discount"]').val()

                $('#product_list tbody tr').each(function(){
                    var _this = $(this)
                    var weight = _this.find('[name="prod_qty[]"]').val()
                    var unit_price = _this.find('[name="prod_price[]"]').val()
                    var total = parseFloat(weight) * parseFloat(unit_price)
                    _this.find('[name="prod_total[]"]').val(total)
                    _this.find('[name="prod_total[]"]').siblings('p').html(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
                    grandtotal+= total;
                })

                grandtotal -= discount;

                $('[name="grandtotal"]').val(grandtotal)
                $('#tamount').html(parseFloat(grandtotal).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
                $('#tamount1').html(parseFloat(grandtotal).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
                
                $('[name="received"]').attr('value', grandtotal)
                change()
            }

            $('[name="received"]').change(function(){
                change()
            })

            function change(){
                var received = $('[name="received"]').val();
                var total = $('[name="grandtotal"]').val();
                var change = parseFloat(received) - parseFloat(total)
                change = parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2})
                if(change > 0){
                    $('[name="amount_change"]').val(change)
                    $('#amount_change').html(parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
                }
            }

            $('#resetbtn').click(function(){
                location.reload();
            })

            $('#process-laundry').submit(function(e){
                var data = $("#process-laundry").serialize();
                $.ajax({
                    type : 'POST',
                    url : 'save_order.php',
                    data : data,
                    success : function(response) {
                        var res = JSON.parse(response);
                        alert(res["message"]);
                        if(res["status"] == 200){
                            setTimeout(function(){
                                location.reload()
                            },800)
                        } else{
                            alert("Error! Unable to save data.");
                        }
                            
                    }
                });

                e.preventDefault();
            })

        </script>
    </body>
</html>