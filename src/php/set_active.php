<?php
require_once('db_connect.php');

$retVal = "";
$status = 400;

if (isset($_POST['activeID'])){
    $id = $_POST['activeID'];

    $query = "UPDATE employee SET status = 1 WHERE employee_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if ($result) {
        $retVal = "User Activated successfully.";
        $status = 200;
        
    } else {
        $retVal = "Error! Failed to Activate User.";
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
