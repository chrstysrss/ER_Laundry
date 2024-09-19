<?php 
    include_once("db_connect.php");

    $role = $retVal = "";
    $status = 400;

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // echo "User: $username | Pass: $password"

    $stmt = $con->prepare("SELECT * FROM employee WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $obj = mysqli_fetch_object($result); 
    $stmt->close();
    if($result->num_rows > 0){
        $isPassword = password_verify ($password , $obj->password);
        if($isPassword == true){
            $_SESSION['SESSIONID'] = $obj->employee_id;
            $_SESSION['username'] = $obj->username;
            $_SESSION['login_fname'] = $obj->first_name;
            $_SESSION['login_lname'] = $obj->last_name;
            $_SESSION['role'] = $obj->role;

            if($obj->status == 1){
                $status = 200;
                $role = $obj->role;
            } else {
                $retVal = "Please contact the administrator to activate your account.";
            }
        } else {
            $retVal = "Invalid password.";
        }
    }else{
        $retVal = "Account does not exist.";
    }
    

    $myObj = array(
        'status' => $status,
        'role' => $role,
        'message' => $retVal  
    );
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>