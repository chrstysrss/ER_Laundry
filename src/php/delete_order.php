<?php
require_once('db_connect.php');

if (isset($_POST['deletesend'])){
    $id = $_POST['deletesend'];

    $delete = mysqli_query($con, "DELETE FROM orders WHERE order_id = $id");
	
	if($delete){
		$delete = mysqli_query($con, "DELETE FROM order_details WHERE order_id = $id");
	}
	header("location:../../public/admin/orders.php");
    exit;
}

exit;
?>