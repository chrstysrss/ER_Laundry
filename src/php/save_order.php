<?php 
    include_once("db_connect.php");

    $retVal = "";
    $isValid = true;
    $status = 400;

    $eid = $_SESSION['SESSIONID'];

    extract($_REQUEST);

    if($received < $grandtotal){
        $isValid = false;
        $retVal = "Error! There is not enough payment received. Unable to save data.";
    }

    if($isValid){
        if($fname == ''){
            $data = "customer_firstname = NULL";
        } else{
            $data = "customer_firstname = '$fname'";
        }

        if($lname == ''){
            $data .= ", customer_lastname = NULL";
        } else{
            $data .= ", customer_lastname = '$lname'";
        }

        if($phone == ''){
            $data .= ", customer_phone = NULL";
        } else{
            $data .= ", customer_phone = '$phone'";
        }

        $data .= ", discount = '$discount'";
        $data .= ", grand_total = '$grandtotal'";
        $data .= ", amount_received = '$received'";
        $data .= ", amount_change = '$amount_change'";
        $data .= ", date = CURDATE()";
        $data .= ", time = CURRENT_TIME()";
        $data .= ", employee_id = '$eid'"; 

        $sql1 = "INSERT INTO orders set $data";

        
        if($con->query($sql1) === TRUE){
            $id = $con->insert_id;
            foreach ($prod_qty as $key => $value) {
                $items = " order_id = '$id' ";
                $items .= ", product_id = '$prod_id[$key]' ";
                $items .= ", quantity = '$prod_qty[$key]' ";
                $items .= ", total = '$prod_total[$key]' ";
                $sql2 = "INSERT INTO order_details set $items";
                if($con->query($sql2) === TRUE){
                    $sql3 = $con->query("UPDATE products SET stock = stock - '$prod_qty[$key]' WHERE product_id = '$prod_id[$key]';");
                }
            }
            $status = 200;
            $retVal = "Order added successfully.";
        }
    }


    $myObj = array(
        'status' => $status,
        'message' => $retVal
    );

    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>