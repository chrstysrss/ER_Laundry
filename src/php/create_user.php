<?php 
    include_once("db_connect.php");

    $retVal = "";
    $isValid = true;
    $status = 400;

    $username = trim($_POST['username']);
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmPass']);
    $activeFlag = 1;

    
    // Check fields are empty or not
    if($username == '' || $fname == '' || $lname == '' || $email == '' || $phone == '' || $role == '' || $password == '' || $confirmpassword == ''){
        $isValid = false;
        $retVal = "Please fill out all fields.";
    }

    // Check if confirm password matching or not
    if($isValid && ($password != $confirmpassword) ){
        $isValid = false;
        $retVal = "Password does not match.";
    }

    // Check if email is valid or not
    if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $retVal = "Invalid email.";
    }

    // Check phone
    if ($isValid && !preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i", $phone)) {
        $isValid = false;
        $retVal = "Invalid contact number.";
    }

    // Check if email already exists
    if($isValid){
        $stmt = $con->prepare("SELECT * FROM employee WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows > 0){
            $isValid = false;
            $retVal = "Email already exist.";
        }
    }

    // Check if phone already exists
    if($isValid){
        $stmt = $con->prepare("SELECT * FROM employee WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows > 0){
            $isValid = false;
            $retVal = "Phone number already exist.";
        }
    }

    // Insert records
    if($isValid){
        $insertSQL = "insert into employee (username, first_name, last_name, password, phone, email, role, status) values(?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($insertSQL);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssssss", $username, $fname, $lname, $password, $phone, $email, $role, $activeFlag);
        $stmt->execute();
        $stmt->close();

        $retVal = "Account created successfully.";
        $status = 200;
    }


    $myObj = array(
        'status' => $status,
        'message' => $retVal  
    );
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;
?>