<?php
  require_once('db_connect.php');

      if(isset($_POST["addProduct"])){
        $data = $_POST["addProduct"];
        $product_name = $data["product_name_add"];
        $description = $data["description_add"];
        $product_type = "Consumables";
        $price = $data["price_add"];
        $stock = $data["stock_add"];

        $stmt = $con->prepare("INSERT INTO products (product_name, product_type, description, price, stock) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssdi", $product_name, $product_type, $description, $price, $stock);
        if($stmt->execute()){
          echo "success";
          exit();
        }else{
          echo "error: " . $stmt->error;
          exit();
        }
        header("location: ../../public/admin/products.php");
      }
  exit();
?>
