<?php
require_once('db_connect.php');

$retVal = "";
$status = 400;

if (isset($_POST['inactiveID'])){
    $id = $_POST['inactiveID'];

    $query = "UPDATE employee SET status = 0 WHERE employee_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if ($result) {
        $retVal = "User Deactivated Successfully.";
        $status = 200;
      
    } else {
        $retVal = "Error! Failed to Deactivate User.";
    }
    $stmt->close();
}

$myObj = array(
    'status' => $status,
    'message' => $retVal  
);
$myJSON = json_encode($myObj);
echo $myJSON;
?>
