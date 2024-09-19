<?php
    include_once("db_connect.php");

//----------System Generated Numbers------------------------------------------//
    
    $isValid = 400;

    do{    
        $length = 4;
        $alpha= substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM"),1,$length);
        $ln = 4;
        $beta = substr(str_shuffle("1234567890"),1,$length);
        
        //----------Validate Username---------------------------------------------//

        $stmt = $con->prepare("SELECT * FROM employee WHERE username = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows == 0){
            $isValid = 200;
            $user_id = $alpha."-".$beta;
        }
    } while($isValid == 400);
?>