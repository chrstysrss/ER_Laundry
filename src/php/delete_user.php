<?php
require_once('db_connect.php');

$retVal = "";
$status = 400;

if (isset($_POST['deletesend'])){

    $id = $_POST['deletesend'];

    $deleteUser = mysqli_query($con, "DELETE FROM employee WHERE employee_id = $id");

    if($deleteUser){
        $retVal = "User deleted successfully.";
        $status = 200;
    } else {
        $retVal = "Error! Failed to delete user.";
    }

}

$myObj = array(
    'status' => $status,
    'message' => $retVal  
);
$myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
echo $myJSON;
?>
