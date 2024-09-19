
$('#signinForm').submit(function(e){
    var data = $("#signinForm").serialize();
    $.ajax({
        type : 'POST',
        url : '../src/php/signin_action.php',
        data : data,
        success : function(response) {
            var res = JSON.parse(response);
            if(res["status"] == 200){
                if(res["role"] == "Employee")
                    window.location.replace('../public/user/dashboard.php'); 
                else 
                    window.location.replace('../public/admin/dashboard.php');
            } else{
                alert(res["message"]);
                $('#signinForm')[0].reset();
            }
        }
    });
    e.preventDefault();
})


$('#newUser').submit(function(e){
    var data = $("#newUser").serialize();
    $.ajax({
        type : 'POST',
        url : '../../src/php/create_user.php',
        data : data,
        success : function(response) {
            var res = JSON.parse(response);
            alert(res["message"]);
            if(res["status"] == 200){
                // $('#newUser')[0].reset();
                location.reload();
            }
        }
    });
    e.preventDefault();
})