<?php
	require_once('../../src/php/db_connect.php');
	
	if(isset($_POST['updateID'])){
		$id = $_POST['updateID'];
		
		$sql = "SELECT * FROM products WHERE product_id = $id";
		$result = mysqli_query($con, $sql);
		$response = array();
		while($row=mysqli_fetch_assoc($result)){
			$response = $row; 
		}
		echo json_encode($response);
	} else {
		$response['status'] = 200;
		$response['message'] = "Invalid or data not found";
	}
	
	
	if(isset($_POST['hiddenData'])){
		$id = $_POST['hiddenData'];
		$name = $_POST['product_name'];
		$desc = $_POST['description'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];


		$data = "product_name = '$name'";

		if($desc == '') $data .= ", description = NULL";
		else $data .= ", description = '$desc'";

		$data .= ", price = '$price'";

		if($stock == '') $data .= ", stock = NULL";
		else $data .= ", stock = '$stock'";

		$sql = "UPDATE products SET $data WHERE product_id = $id";

		$result = mysqli_query($con, $sql);
	}

?>
