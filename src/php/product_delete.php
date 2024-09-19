<?php
require_once('../../src/php/db_connect.php');
if (isset($_POST['deletesend'])){
    $id = $_POST['deletesend'];

    $delete=mysqli_query($con, "DELETE FROM products WHERE product_id = $id");
	
	if($delete){
		echo "Deleted successfully";
	}
	header("location:../../public/admin/products.php");
    exit;
}

exit;
?>
